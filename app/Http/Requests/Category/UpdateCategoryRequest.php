<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có được phép thực hiện yêu cầu này hay không.
     */
    public function authorize(): bool
    {
        return true; // Cho phép mọi người dùng thực hiện yêu cầu này
    }

    /**
     * Quy tắc xác thực áp dụng cho yêu cầu.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $this->category_id . ',category_id',
            'status' => 'required|in:0,1',
            'description' => 'nullable|string|max:255',
        ];
    }

    /**
     * Thông báo lỗi tùy chỉnh.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng điền tên danh mục.',
            'name.unique' => 'Danh mục ":input" đã tồn tại.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
        ];
    }
}
