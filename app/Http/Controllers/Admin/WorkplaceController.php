<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workplace;
use Illuminate\Http\Request;

class WorkplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Workplace::with('rooms');
    
        // Lọc theo tên workplace
        if ($request->filled('workplace')) {
            $query->where('workplace', 'like', '%' . $request->workplace . '%');
        }
    
        // Lọc theo mã bưu điện (zipcode)
        if ($request->filled('zipcode')) {
            $query->where('zipcode', 'like', '%' . $request->zipcode . '%');
        }
    
        // Lấy kết quả với phân trang
        $workplaces = $query->paginate(10);
    
        return view('admin.workplaces.index', compact('workplaces'));
    }

    public function show($id)
    {
        $workplace = Workplace::with(['rooms.statuses'])->findOrFail($id);
        return view('admin.workplaces.show', compact('workplace'));
    }

    public function create()
    {
        return view('admin.workplaces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'workplace' => 'required|string|max:255',
            'zipcode' => 'required|regex:/^\d{7}$/', // Mã bưu điện phải là 7 chữ số
            'address' => 'required|string',
            'total_rooms' => 'nullable|integer|min:0',
            'linen' => 'nullable|string|max:255',
            'laundry_distance' => 'nullable|string|max:255', // Cập nhật trường này là kiểu text
        ]);

        Workplace::create($request->all());

        return redirect()->route('admin.workplaces.index')->with('success', '職場が正常に作成されました。');
    }

    public function edit($id)
    {
        $workplace = Workplace::with('rooms')->findOrFail($id);
        return view('admin.workplaces.edit', compact('workplace'));
    }

    public function update(Request $request, Workplace $workplace)
    {
        $request->validate([
            'workplace' => 'required|string|max:255',
            'zipcode' => 'required|regex:/^\d{7}$/', // Mã bưu điện phải là 7 chữ số
            'address' => 'required|string',
            'total_rooms' => 'nullable|integer|min:0',
            'linen' => 'nullable|string|max:255',
            'laundry_distance' => 'nullable|string|max:255', // Cập nhật trường này là kiểu text
        ]);

        $workplace->update($request->all());

        return redirect()->route('admin.workplaces.index')->with('success', '職場情報が正常に更新されました。');
    }

    public function destroy(Workplace $workplace)
    {
        $workplace->delete();
        return redirect()->route('admin.workplaces.index')->with('success', '職場が削除されました。');
    }
}
