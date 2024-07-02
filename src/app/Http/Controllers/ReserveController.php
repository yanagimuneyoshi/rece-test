<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReserveController extends Controller
{
  public function storeReserve(Request $request)
  {
    $request->validate([
      'shop_id' => 'required|exists:shops,id',
      'date' => 'required|date',
      'time' => 'required',
      'guests' => 'required|integer|min:1',
    ]);

    Reserve::create([
      'shop_id' => $request->shop_id,
      'user_id' => Auth::id(),
      'date' => $request->date,
      'time' => $request->time,
      'people' => $request->guests,
    ]);

    return redirect()->route('done');
  }

  public function deleteReservation($id)
  {
    $reservation = Reserve::where('id', $id)
      ->where('user_id', Auth::id())
      ->first();

    if ($reservation) {
      $reservation->delete();
      \Log::info("Reservation with ID {$id} deleted successfully.");
      return response()->json(['status' => 'success']);
    }

    \Log::error("Failed to delete reservation with ID {$id}. User ID mismatch or reservation not found.");
    return response()->json(['status' => 'error'], 403);
  }
}
