@extends('layouts.web')

@php
    $wallpaperInterval = 10000;
    $slideInterval = 3000;

    $db	= json_decode(file_get_contents(database_path('database.json')), true);
    $showDb	= $db;
    unset($showDb['akses']);
    // dd($db['info']);

    $praySetting = fluent(array_merge($db['setting'], [
        'method' => '0',
    ]));

    $info_timer			= $db['timer']['info'] 		* 1000;	//detik
    $wallpaper_timer	= $db['timer']['wallpaper'] * 1000;
    $adzan_timer		= $db['timer']['adzan'] 	* 1000 * 60; //menit
    $iqomah_timer		= ($db['timer']['iqomah'] ?? 3) 	* 1000 * 60;
    $sholat_timer		= $db['timer']['sholat'] 	* 1000 * 60;

    //optional
    $khutbah_jumat		= $db['jumat']['duration'] 	* 1000 * 60;
    $sholat_tarawih		= $db['tarawih']['duration'] 	* 1000 * 60;

    //Logo
    // nge trik ==> kalo replace file, di display logo yang lama masih kesimpen di cache ==> solusi ganti logo ganti nama file
    // $dirLogo	= public_path('app/logo');
    // $filesLogo	= array_diff(scandir($dirLogo), ['.', '..', 'Thumbs.db']);
    // $filesLogo	= array_values($filesLogo);//re index
    // $logo		= $filesLogo[0];

    if ($wallpapers->isEmpty()) {
        $dir	= public_path('app/wallpaper');
        $wallpapers	= collect(array_diff(scandir($dir), ['.', '..', 'Thumbs.db']))->shuffle()->flatten()
            ->map(fn ($wall) => fluent(['url' => asset('app/wallpaper/'.$wall)]));
    }

    $qrisElement = '';
    if ($qris->get('url')) {
        $qrisElement = "<img src=\"{$qris->get('url')}\" alt=\"\" style=\"height:{$qris->get('height')}vh;\">";
    }

    $prayTimeManual = '';
    $prayTimeManualClass = '';
    if ($prayTime->has('tanggal')) {
      $times = [
        'imsak' => 'Imsak',
        'subuh' => 'Subuh',
        'terbit' => 'Syuruq',
        'dzuhur' => 'Dzuhur',
        'ashar' => 'Ashar',
        // 'sunset' => 'Sunset',
        'maghrib' => 'Maghrib',
        'isya' => 'Isya\''
      ];
      $prayTimeManualClass = ' manual';
      foreach ($times as $key => $val) {
        $prayTimeManual .= "<div class='row'><div class='col-xs-5'>{$val}</div><div class='col-xs-7'>{$prayTime->get($key)}</div></div>";
      }
    }
@endphp

@section('content')
  <div id="preloader">
    <div id="status">&nbsp;</div>
  </div>

  <div id="full-screen-clock" style="display:none"></div>
  <div id="count-down" class="full-screen" style="display:none">
    <div class="counter">
      <h1>COUNTER</h1>
      <div class="hh">00<span>JAM</span></div>
      <div class="ii">00<span>MENIT</span></div>
      <div class="ss">00<span>DETIK</span></div>
    </div>
  </div>
  <div id="display-adzan" class="full-screen" style="display:none"><div></div></div>
  <div id="display-sholat" class="full-screen" style="display:none"></div>
  <div id="display-khutbah" class="full-screen" style="display:none"><div></div></div>


  <div class="carousel carousel-fade slide" data-bs-ride="carousel">
    <!-- Overlay -->
    <div class="overlay"></div>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      @forelse($wallpapers as $wid => $wall)
        <div class="carousel-item slides {{ $wid == 0 ? 'active' : '' }}" data-bs-interval="{{ (int) ($wall->get('timer') ?? $wallpaperInterval) }}">
          <div style="background-image: url('{{ $wall->get('url') }}');"></div>
        </div>
      @empty
      @endforelse
    </div>
  </div>

  <div id="left-background"></div>
  <div id="left-container">
    <div class="masjid-name">{{ $masjid->name }}</div>
    <div id="jam"></div>
    <div id="tgl"></div>
    <div id="jadwal" class="{{ $prayTimeManualClass }}">{!! $prayTimeManual !!}</div>
    <div id="cash_flow">
      <div class="cash d-flex justify-content-between">
        <div>Tunai:</div>
        <div class="amount">Rp. {{ numberFormat($balance?->complex['cash'] ?? 0) }}</div>
      </div>
      <div class="non-cash d-flex justify-content-between">
        <div>Rekening:</div>
        <div class="amount">Rp. {{ numberFormat($balance?->complex['bank_account'] ?? 0) }}</div>
      </div>
    </div>
  </div>

  <div id="right-counter" style="display:none">
    <div class="counter">
      <h1>COUNTER</h1>
      <div class="hh">00<span>JAM</span></div>
      <div class="ii">00<span>MENIT</span></div>
      <div class="ss">00<span>DETIK</span></div>
    </div>
  </div>
  <div id="right-container">
    <div id="quote">
      <div class="carousel quote-carousel slide" data-bs-ride="carousel" data-bs-pause="false">
        <div class="carousel-group">
          <div>{!! $qrisElement !!}</div>
          <div class="carousel-inner">
            @forelse($slides as $sid => $_slide)
              @php
                $slide = fluent(\Illuminate\Support\Arr::dot($_slide));
                $slideContent = nl2br(e($slide->get('content')));
                $content = '';
                if ($slide->get('type') == 'content') {
                  if($slide->get('title')) {
                    $slideTitle = e($slide->get('title'));
                    $content .= "<div class='quote-title'>{$slideTitle}</div>";
                  }
                  $content .= "<div class='quote-content'>{$slideContent}</div>";
                  if($slide->get('source')) {
                    $slideSource = e($slide->get('source'));
                    $content .= "<div class='quote-source'>{$slideSource}</div>";
                  }

                  $contentActive = $sid == 0 ? ' active' : '';
                  $contentInterval = (int) ($slide->get('timer') ?? $slideInterval);
                  $content = "<div class='carousel-item slides{$contentActive}' data-bs-interval='{$contentInterval}'><div class='hero'>{$content}</div></div>";
                }
                echo $content;
              @endphp
            @empty
            @endforelse
          </div>
        </div>
      </div>
    </div>
    <div id="logo">
      <div class="h-100 d-flex flex-column justify-content-end">
        <div><img src="{{ cachedAsset('app/logo-bank-muamalat.png') }}" alt="" height="75"></div>
        <span class="text-light" style="font-size: 1vw;">Powered by Bank Muamalat Indonesia</span>
      </div>
    </div>
    <div id="running-text">
      <div class="item">
        <!-- <div class="text"> -->
        <marquee>
          {!! $runningText->map(fn ($t) => '<i class="fa fa-square-o" aria-hidden="true"></i> '.e($t))->implode('') !!}
          {{--<?php
          foreach($db['running_text'] as $k => $v){
            echo '<i class="fa fa-square-o" aria-hidden="true"></i> '.htmlentities($v);
          }
          // $ip 	= gethostbyname(php_uname('n'));	// PHP < 5.3.0
          $ip 	= gethostbyname(gethostname());		// PHP >= 5.3.0 ==> di linux keluar 127.0.0.1
          if(PHP_OS=='Linux'){
            //raspi 3
            // $command="/sbin/ifconfig wlan0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'";//raspi pake wlan0 jadi hotspot
            // $ip = exec ($command);

            //raspi 4
            $command="/sbin/ifconfig wlan0 | grep 'inet '| cut -d 't' -f2 | cut -d 'n' -f1 | awk '{ print $1}'";//raspi pake wlan0 jadi hotspot
            $ip = trim(exec ($command));
          }
          if($db['akses']['pass']=='admin'){
            echo '<i class="fa fa-square-o" aria-hidden="true"></i> Konek ke wifi (SSID: DisplayMasjid, password: 12345678)';
            echo '<i class="fa fa-square-o" aria-hidden="true"></i> Alamat admin http://'.$ip.'/';
            echo '<i class="fa fa-square-o" aria-hidden="true"></i> Default akses user : admin, password : admin';
            echo '<i class="fa fa-square-o" aria-hidden="true"></i> Silakan mengganti password admin untuk menghilangkan tulisan ini';
          }
          ?>--}}
        </marquee>
        <!-- </div> -->
      </div>
    </div>
  </div>

  <div class="blackout" id="blackout"></div>

  <audio id="beepAudio">
    <source src="{{ asset('app/img/beep.mp3') }}" type="audio/mpeg">
    Your browser does not support the audio element.
  </audio>
@endsection

@push('style')
  <link rel="stylesheet" href="{{ cachedAsset('app/css/display.css') }}">
@endpush

@push('script')
  <script src="{{ cachedAsset('app/js/PrayTimes.js') }}"></script>
  <script src="{{ cachedAsset('app/js/jquery.marquee.js') }}"></script>
  <script src="{{ cachedAsset('app/js/display.js') }}"></script>
  <script>
    const numFmt = Intl.NumberFormat('id-ID')
    $(function () {
      // $.post('slide/next')
      //   .done(function (_res) {
      //     //
      //   });
      setInterval(function () {
        $.get('{{ routed('display.balance', [$masjid->hash]) }}')
          .done(function (rs) {
            if (rs.status === 'success') {
              $('#cash_flow .cash .amount').html(`Rp. ${numFmt.format(rs.data.cash ?? 0)}`)
              $('#cash_flow .non-cash .amount').html(`Rp. ${numFmt.format(rs.data.bank_account ?? 0)}`)
            }
          })
      }, 30000)
    })
  </script>
@endpush
