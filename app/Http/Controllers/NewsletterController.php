<?php
// filepath: d:\trasuashop\milkteashop\app\Http\Controllers\NewsletterController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Logic to save the email to the database or send it to a mailing service
        // Example:
        // Newsletter::create(['email' => $request->email]);

        return redirect()->back()->with('success', 'Bạn đã đăng ký nhận tin thành công!');
    }
}