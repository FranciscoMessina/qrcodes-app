<?php

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;


new
#[\Livewire\Attributes\Layout('layouts.app')]
class extends \Livewire\Volt\Component {
    public \Illuminate\Support\Collection $qr_codes;

    public function mount(): void
    {
        $qr_codes = auth()->user()->qr_codes()->latest()->limit(10)->get();


        $qrs = $qr_codes->map(function ($qr) {
            $qrCode = QrCode::create($qr->data)
                ->setEncoding(new \Endroid\QrCode\Encoding\Encoding('UTF-8'))
                ->setErrorCorrectionLevel(\Endroid\QrCode\ErrorCorrectionLevel::High)
                ->setSize(80)
                ->setMargin(5)
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));


            $label = \Endroid\QrCode\Label\Label::create($qr->name)
                ->setTextColor(new Color(255, 0, 0));

            $writer = new SvgWriter([
                SvgWriter::WRITER_OPTION_EXCLUDE_XML_DECLARATION => true
            ]);


            $qr['result'] = $writer->write($qrCode, null, $label);
            return $qr;
        });


        $this->qr_codes = $qrs;


    }
}
?>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-6 text-gray-900">
                <form action="{{ route('qrs.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <x-text-input type="text" name="name"/>
                    <select name="type" class="rounded">
                        <option value="link">Link</option>
                        <option value="v_card">vCard</option>
                        <option value="whatsapp">WhatsApp</option>
                    </select>

                    <x-text-input type="text" name="data"/>

                    <x-primary-button type="submit">Create QR</x-primary-button>

                </form>


                @foreach($this->qr_codes as $qr_code)
                    <livewire:qr_code :qr="$qr_code"/>

                @endforeach


            </div>
        </div>
    </div>
</div>
