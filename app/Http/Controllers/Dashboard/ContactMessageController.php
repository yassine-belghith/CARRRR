<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Exports\ContactMessagesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $messages = ContactMessage::latest()->paginate(15);
        
        if ($request->ajax()) {
            return response()->json([
                'data' => $messages->map(function($message) {
                    return [
                        'id' => $message->id,
                        'name' => $message->name,
                        'email' => $message->email,
                        'message' => $message->message,
                        'created_at' => $message->created_at->format('d/m/Y H:i'),
                        'is_read' => $message->is_read 
                            ? '<span class="badge bg-success">Lu</span>'
                            : '<span class="badge bg-warning text-dark">Non lu</span>',
                        'action' => view('dashboard.contact-messages.actions', ['message' => $message])->render()
                    ];
                }),
                'links' => $messages->links()->toHtml()
            ]);
        }
        
        return view('dashboard.contact-messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Supprimer plusieurs messages
     */
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun message sélectionné.'
            ], 400);
        }
        
        $count = ContactMessage::whereIn('id', $ids)->delete();
        
        return response()->json([
            'success' => true,
            'message' => $count . ' message(s) supprimé(s) avec succès.'
        ]);
    }
    
    /**
     * Exporter les messages
     */
    public function export()
    {
        $fileName = 'messages-contact-' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new ContactMessagesExport, $fileName);
    }
    
    /**
     * Obtenir les statistiques des messages
     */
    public function stats()
    {
        $total = ContactMessage::count();
        $unread = ContactMessage::unread()->count();
        $today = ContactMessage::whereDate('created_at', today())->count();
        $thisWeek = ContactMessage::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        
        return response()->json([
            'total' => $total,
            'unread' => $unread,
            'today' => $today,
            'this_week' => $thisWeek
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactMessage $contactMessage)
    {
        // Marquer le message comme lu
        if (!$contactMessage->is_read) {
            $contactMessage->markAsRead();
        }
        
        return view('dashboard.contact-messages.show', compact('contactMessage'));
    }

    /**
     * Marquer un message comme lu/non lu
     */
    public function toggleReadStatus(ContactMessage $contactMessage)
    {
        $contactMessage->update([
            'is_read' => !$contactMessage->is_read,
            'read_at' => $contactMessage->is_read ? null : now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Statut de lecture mis à jour avec succès',
            'is_read' => $contactMessage->fresh()->is_read
        ]);
    }

    /**
     * Supprimer un message
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Message supprimé avec succès'
        ]);
    }
    

}
