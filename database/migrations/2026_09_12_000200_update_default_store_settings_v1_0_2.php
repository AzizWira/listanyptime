<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $this->replaceDefault('store_name', 'Pinky List', '@anyptime list');
        $this->replaceDefault('whatsapp_number', '6281234567890', '628132628586');
        $this->replaceDefault('whatsapp_closing', 'Mohon dibantu proses ya kak, terima kasih 🎀', 'Mohon dibantu proses ya kak, terima kasih.');
    }

    public function down(): void
    {
        $this->replaceDefault('store_name', '@anyptime list', 'Pinky List');
        $this->replaceDefault('whatsapp_number', '628132628586', '6281234567890');
        $this->replaceDefault('whatsapp_closing', 'Mohon dibantu proses ya kak, terima kasih.', 'Mohon dibantu proses ya kak, terima kasih 🎀');
    }

    private function replaceDefault(string $key, string $from, string $to): void
    {
        DB::table('store_settings')
            ->where('key', $key)
            ->where('value', $from)
            ->update(['value' => $to, 'updated_at' => now()]);
    }
};
