<form method="POST" action="{{ route('notifikasi-bimbingan.store') }}">
  @csrf

  {{-- Preview Pesan --}}
  <div class="mb-4">
    <x-label>
      Header Pesan by System
    </x-label>

    <x-textarea class="mb-4" disabled rows=8>
      {{$pesanSistem}}
    </x-textarea>
    <textarea hidden id="pesan_sistem">{{ $pesanSistem }}</textarea>

    <div class="flex gap-2 mb-2 mt-4">
      <div>
        <input type="checkbox" id="check_pesan_auto" checked autocomplete="off">
      </div>
      <x-label class="cursor-pointer" for="check_pesan_auto">Add Pesan Otomatis</x-label>
    </div>
    <div id="blok_auto_message">
      <x-textarea rows="5" id="pesan_auto" class="editablez">
        {{ $pesanAuto }}
      </x-textarea>
    </div>

    <div class="flex gap-2 mb-2 mt-4">
      <div>
        <input type="checkbox" id="check_pesan_tambahan" autocomplete="off">
      </div>
      <x-label class="cursor-pointer" for="check_pesan_tambahan">Add Pesan Tambahan</x-label>
    </div>
    <x-textarea rows="5" name="wa_message_template" id="wa_message_template" class="editablez"
      placeholder="Tulis pesan template Anda disini... akan dapat digunakan ke seluruh peserta pada bimbingan ini.">
      {{ $peserta->bimbingan->wa_message_template }}
    </x-textarea>
    <p class="mb-3 text-xs text-gray-500 right">
      <i>)* message template is autosave</i>
    </p>



    <x-textarea class="mb-4" disabled rows="{{$pesanLink?6:4}}" id="pesan_footer">
      {{$pesanLink ? "\n\nLink:\n".$pesanLink : ''}}{{$pesanFooter}}
    </x-textarea>

    <p class="mt-1 text-xs text-gray-500">
      Pesan ini akan dikirim ke WhatsApp mhs {{$whatsappUI}}.
    </p>
  </div>

  <div class="hiddena">
    <x-textarea name="pesan" id="pesan" rows="10"></x-textarea>
    <input name="peserta_bimbingan_id" value="{{$peserta->id}}">
    <input name="status_sesi_bimbingan" value="{{$statusSesi->value}}">
    <input name="status_terakhir_bimbingan" value="{{$statusWaktu->value}}">
  </div>


  {{-- Action --}}
  <div class="flex items-center justify-between">
    <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:underline">
      ← Kembali
    </a>

    <x-button btn="primary">
      <span class="flex items-center gap-2">
        @include('components.whatsapp-icon')
        Kirim WhatsApp
      </span>
    </x-button>
  </div>
</form>

<script>
  function rekap_pesan(){
    let pesan_sistem = $('#pesan_sistem').val();
    let pesan_auto = $('#check_pesan_auto').prop('checked') ? '\n\n'+$('#pesan_auto').val() : '';
    let wa_message_template = (
        $('#check_pesan_tambahan').prop('checked')
        && $('#wa_message_template').val()
      ) 
      ? '\n\nPesan Tambahan:\n'+$('#wa_message_template').val() 
      : '';
    let pesan_footer = '\n\n'+$('#pesan_footer').val();
    $('#pesan').val(
      pesan_sistem 
      + pesan_auto 
      + wa_message_template 
      +pesan_footer
    )
  }



  $(function(){
    rekap_pesan();
    $('.editablez').on('input', rekap_pesan())
    $('#check_pesan_auto').change(function(){
      if($(this).prop('checked')){
        $('#blok_auto_message').slideDown()
      }else{
        $('#blok_auto_message').slideUp()
      }
      rekap_pesan();
    })
    $('#check_pesan_tambahan').change(function(){
      $('#wa_message_template').prop('required',$(this).prop('checked'))
      rekap_pesan();
    })
  })
</script>