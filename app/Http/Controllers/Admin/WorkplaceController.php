<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Thêm dòng này để khai báo model User
use App\Models\Task;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WorkplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Workplace::query();
    
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
    

    public function create()
    {
        return view('admin.workplaces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'workplace' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'address' => 'required|string',
        ]);

        Workplace::create($request->all());

        return redirect()->route('admin.workplaces.index')->with('success', 'Workplace created successfully.');
    }

    public function edit($id)
    {
        $workplace = Workplace::findOrFail($id);
        return view('admin.workplaces.edit', compact('workplace'));
    }
    
    public function update(Request $request, Workplace $workplace)
    {
        $request->validate([
            'workplace' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'address' => 'required|string',
        ]);

        $workplace->update($request->all());

        return redirect()->route('admin.workplaces.index')->with('success', 'Workplace updated successfully.');
    }

    public function destroy(Workplace $workplace)
    {
        $workplace->delete();
        return redirect()->route('admin.workplaces.index')->with('success', 'Workplace deleted successfully.');
    }
}

