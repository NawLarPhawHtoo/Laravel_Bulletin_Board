<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExportPost implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting, WithStrictNullComparison
{
  private $filter;
  private $exportAll;
  private $userId;

  public function __construct($exportAll = false, $userId = null, $filter = null)
  {
    $this->exportAll = $exportAll;
    $this->userId = $userId;
    $this->filter = $filter;
  }

  /**
   * @return \Illuminate\Support\Collection
   */

  public function collection()
  {
    $query = Post::query();

    if ($this->exportAll) {
      if (auth()->user()->type == 1) {
        $query->where('status', 1);
      }
      $query->select("id", "title", "description", "status", "created_user_id", "updated_user_id", "created_at", "updated_at");
    } else {
      $query->where('created_user_id', $this->userId)
        ->whereIn('status', [0, 1])
        ->select("id", "title", "description", "status", "created_user_id", "updated_user_id", "created_at", "updated_at");
    }

    if ($this->filter) {
      $query->where(function ($q) {
        $q->where('title', 'like', '%' . $this->filter . '%')
          ->orWhere('description', 'like', '%' . $this->filter . '%');
      });
    }

    return $query->get();
  }
  public function headings(): array
  {
    return ["id", "title", "description", "status", "created_user_id", "updated_user_id", "created_at", "updated_at"];
  }

  // Select data from query and set its position
  public function map($post): array
  {
    $status = ($post->status == 1) ? 'Active' : 'Inactive';
    return [
      $post->id,
      $post->title,
      $post->description,
      $status,
      $post->created_user_id,
      $post->updated_user_id,
      Date::dateTimeToExcel($post->created_at),
      Date::dateTimeToExcel($post->updated_at),
    ];
  }

  // Set Date Format
  public function columnFormats(): array
  {
    return [
      'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
      'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
    ];
  }
}
