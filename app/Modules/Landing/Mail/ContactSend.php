<?php
/**
 *  app/Modules/Landing/Mail/ContactSend.php
 *
 * Date-Time: 09.08.21
 * Time: 10:23
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Landing\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    protected array $data;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): ContactSend
    {
        return $this->from($this->data['to'], $this->data['name'])
            ->subject($this->data['subject'])->view('email.contact', ['data' => $this->data]);
    }
}
