<?php

namespace App\Imports;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportPost implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Post([
            'title' => $row['title'],
            'description' => $row['description'],
            'status' => $row['status'],
            'created_user_id' => Auth::user()->id,
            'updated_user_id' => Auth::user()->id,
        ]);
    }

    public function rules(): array
    {
        return [

            '*.title' => [
                'required',
                Rule::unique('posts', 'title')->where(function ($query) {
                    return $query->where('created_user_id', Auth::user()->id);
                }),
            ]
        ];
    }
}
