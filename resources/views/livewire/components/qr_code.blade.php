<?php

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;

new class extends \Livewire\Volt\Component {
    public \App\Models\QrCode $qr;


    public function mount(\App\Models\QrCode $qr)
    {
        $qr['url'] = config('app.url') . '/qr/' . $qr->url_id;


        $qrCode = QrCode::create($qr['url'])
            ->setEncoding(new \Endroid\QrCode\Encoding\Encoding('UTF-8'))
            ->setErrorCorrectionLevel(\Endroid\QrCode\ErrorCorrectionLevel::High)
            ->setSize(80)
            ->setMargin(5)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));


        $label = \Endroid\QrCode\Label\Label::create($qr->name)
            ->setTextColor(new Color(255, 0, 0));

        $writer = new SvgWriter();


        $qr['result'] = $writer->write($qrCode, null, $label);

        $this->qr = $qr;
    }


}


?>

<tr id="{{ $qr->url_id }}">
    <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
        <div class="flex items-center" @click="
            navigator.clipboard.writeText('{{ $qr->url }}')
        ">

            {!! $qr->result->getString() !!}

            <div class="ml-4">
                <div class="font-medium text-gray-900">{{ $qr->name }}</div>

            </div>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
        <div class="text-gray-900 capitalize">{{ $qr->type }}</div>

    </td>
    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
        <span
            class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
            Active
        </span>
    </td>
    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
        {{ $qr->data }}
    </td>
    <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
        <div class="flex justify-between w-12 gap-4">


            <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor"
                     class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </a>

            <button wire:click="$parent.deleteQr({{ $qr->id }})" wire:confirm="Wanna delete me?">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                </svg>
            </button>


            <button x-on:click="
                        const svg = document.getElementById('{{ $qr->url_id }}').querySelector('svg').cloneNode(true)
                        svg.style.width = '250px'
                        svg.style.height = '250px'
                        const base64doc = btoa(unescape(encodeURIComponent(svg.outerHTML)));
                        const a = document.createElement('a');
                        const e = new MouseEvent('click');
                        a.download = 'download.svg';
                        a.href = 'data:image/svg+xml;base64,' + base64doc;
                        a.dispatchEvent(e);
            ">
                <span class="sr-only">download</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
                </svg>
            </button>
        </div>

    </td>
</tr>


