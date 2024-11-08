<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Workplace;
use Illuminate\Http\Request;
use App\Models\RoomStatus;
use App\Models\StatusType;


class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('workplace')->paginate(10); 
        return view('admin.rooms.index', compact('rooms'));
    }
    
    public function show($id)
    {
        // Lấy thông tin phòng cùng với nơi làm việc và các trạng thái liên quan
        $room = Room::with(['workplace', 'statuses'])->findOrFail($id);
    
        return view('admin.rooms.show', compact('room'));
    }
    
    public function create($workplaceId)
    {
        $workplace = Workplace::findOrFail($workplaceId);
        $statusTypes = StatusType::all(); 
        return view('admin.rooms.create', compact('workplace', 'statusTypes'));
    }
    
    public function edit($id)
    {
        $room = Room::with('workplace')->findOrFail($id);
        $statusTypes = StatusType::all(); // Lấy tất cả các trạng thái từ bảng status_types
        return view('admin.rooms.edit', compact('room', 'statusTypes'));
    }
    
    
    public function store(Request $request)
    {
        $request->validate([
            'workplace_id' => 'required|exists:workplaces,id',
            'room_number' => 'required|string|max:255',
            // Các quy tắc xác thực khác nếu cần
        ]);
    
        // Kiểm tra số phòng trong cùng một nơi làm việc
        $existingRoom = Room::where('workplace_id', $request->workplace_id)
                            ->where('room_number', $request->room_number)
                            ->first();
    
        if ($existingRoom) {
            return redirect()->back()->withInput()->with('error', 'この部屋番号はすでに存在しています。');
        }
    
        try {
            // Logic thêm mới dữ liệu
            $room = Room::create($request->all());
    
            // Chuyển hướng đến trang chi tiết của nơi làm việc sau khi thêm phòng
            return redirect()->route('admin.workplaces.show', $room->workplace_id)->with('success', '部屋が正常に追加されました。');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'エラーが発生しました: ' . $e->getMessage());
        }
    }
    
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'room_number' => 'required|string|max:255',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);
    
        try {
            $room = Room::findOrFail($id);
            $room->update($request->only(['room_number', 'status', 'notes']));
    
            // Chuyển hướng đến trang chi tiết của workplace liên quan
            return redirect()->route('admin.workplaces.show', $room->workplace_id)->with('success', '部屋情報が正常に更新されました。');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'エラーが発生しました: ' . $e->getMessage());
        }
    }
    

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $workplaceId = $room->workplace_id;
        $room->delete();

        return redirect()->route('admin.workplaces.show', $workplaceId)->with('success', '部屋が削除されました。');
    }
}
