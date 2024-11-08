<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workplace;
use Illuminate\Http\Request;

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
            'zipcode' => 'required|string|max:10',
            'address' => 'required|string',
            'total_rooms' => 'nullable|integer|min:0',
            'linen' => 'nullable|string|max:255',
            'nearest_laundromat_distance' => 'nullable|numeric',
        ]);

        Workplace::create($request->all());

        return redirect()->route('admin.workplaces.index')->with('success', 'Workplace created successfully.');
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
            'zipcode' => 'required|string|max:10',
            'address' => 'required|string',
            'total_rooms' => 'nullable|integer|min:0',
            'linen' => 'nullable|string|max:255',
            'nearest_laundromat_distance' => 'nullable|numeric',
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
