<?php

new class extends \Livewire\Volt\Component {
    public \App\Models\QrCode $qr;
}


?>

<div class="flex items-center justify-evenly mt-10" id="{{ $qr->url_id }}">

    {!! $qr->result->getString() !!}
    <span class="capitalize">
        {{ $qr->name }}
    </span>

    <span>
        {{ $qr->type }}
    </span>

    <span>
        {{ $qr->data }}
    </span>


    <div class="flex gap-2">


    <span>
        <a href="">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            </svg>
        </a>
    </span>

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

</div>
