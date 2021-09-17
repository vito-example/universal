<?php
/**
 *  app\Modules\Landing\Mail\VerifySend.php
 *
 * Date-Time: 9/16/2021
 * Time: 6:04 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Landing\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifySend extends Mailable
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
    public function build(): VerifySend
    {
        return $this->from($this->data['to'], $this->data['name'])
            ->subject($this->data['subject'])->view('email.verify', ['data' => $this->data]);
    }
}
