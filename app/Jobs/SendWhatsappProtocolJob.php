<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsappProtocolJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $phone;
    public string $protocol;
    public string $date;

    public $tries = 3;
    public $backoff = 10;

    /**
     * Create a new job instance.
     */
    public function __construct( string $phone, string $protocol, string $date  )
    {
        $this->phone = $phone;
        $this->protocol = $protocol;
        $this->date = $date;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ramdomNumber = random_int(1, 100);

        Log::info("Tentando enviar a mensagem para {$this->phone} | Número gerado {$ramdomNumber}");

        if ($ramdomNumber % 2 === 0) {
            Log::info("Mensagem enviada com sucesso para {$this->phone} (Protocolo: {$this->protocol} | Data: {$this->date})");
        } else {
            Log::warning("Falha ao enviar a mensagem para {$this->phone} (Protocolo: {$this->protocol} | Data: {$this->date})");
            throw new \Exception ("Erro simulado no envio da mensagem");
        }
    }
}
