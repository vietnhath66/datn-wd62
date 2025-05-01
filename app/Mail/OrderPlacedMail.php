<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $orderCode = $this->order->barcode ?? ('DH' . $this->order->id);
        return new Envelope(
            // Lấy địa chỉ From từ config('mail.from.address') và tên từ config('mail.from.name')
            from: new \Illuminate\Mail\Mailables\Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'Xác nhận Đơn hàng #' . $orderCode . ' đã được đặt thành công!', // Tiêu đề email
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.placed', // Đường dẫn tới file view (resources/views/emails/orders/placed.blade.php)
            with: [
                'orderUrl' => route('client.account.accountOrderDetail', $this->order->id), // Tạo URL xem chi tiết đơn hàng (CHECK ROUTE NAME)
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
