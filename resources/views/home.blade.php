@include('templates/headerLogado')
@extends('layouts.app')
<body>

@section('conteudo')

    {{-- BANNER --}}
    <section class="banner">

        <video autoplay loop muted id="video-destaque">
            <source src="{{ asset('videos/kh3trailerSHORT720.mp4') }}" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>

        <div class="overlay"></div>

        <div class="texto-destaque">
			<h2>Kingdom Hearts III</h2>
			<h3>Trailer de lançamento pra plataforma PC(steam)</h3>
			<p>Imagina se fosse verdade, seria muito bom.</p>
			<br />
			<a href="https://youtu.be/2VawSnaxtSI"><i class="fas fa-play"></i> Assistir</a>
			<a href="https://store.steampowered.com/"><i class="fab fa-steam"></i> Comprar</a>
			<a href="https://www.kingdomhearts.com/home/gb/"><i class="fas fa-globe-americas"></i> Site</a>
		</div>


    </section>


    {{-- CAROUSELS --}}
    <section id="exclusivos" class="vitrine">
        <h3 class="carousel-title">Filmes e Séries <b>jaoflix</b> exclusivas</h3>
		<div class="vitrine-flex">
            @foreach ($exclusivos as $exclusivo)
                <div class="vitrine-single-banner">
                    <div class="vitrine-wraper" style="background-image: url('images/uploads/<?= $exclusivo->imagem_capa ?>');"></div>
                </div>
            @endforeach
            <div class="clearfix"></div>
	    </div>	<!--vitrine-flex-->
    </section>

    <section id="filmes" class="vitrine">
        <h3 class="carousel-title">Filmes</h3>
		<div class="vitrine-flex">
            @foreach ($filmes as $filme)
            <div class="vitrine-single-banner">
                <div class="vitrine-wraper" style="background-image: url('images/uploads/<?= $filme->imagem_capa ?>');"></div>
            </div>
            @endforeach
            <div class="clearfix"></div>
	    </div>	<!--vitrine-flex-->
    </section>

    <section id="series" class="vitrine">
        <h3 class="carousel-title">Séries</h3>
		<div class="vitrine-flex">
            @foreach ($series as $serie)
                <div class="vitrine-single-banner">
                    <div class="vitrine-wraper" style="background-image: url('images/uploads/<?= $serie->imagem_capa ?>');"></div>
                </div>
            @endforeach
            <div class="clearfix"></div>
	    </div>	<!--vitrine-flex-->
	</section>

	<section id="infantil" class="vitrine">
        <h3 class="carousel-title">Infantil</h3>
		<div class="vitrine-flex">
            @foreach ($infantils as $infantil)
            <div class="vitrine-single-banner">
                <div class="vitrine-wraper" style="background-image: url('images/uploads/<?= $infantil->imagem_capa ?>');"></div>
            </div>
            @endforeach
            <div class="clearfix"></div>
	    </div>	<!--vitrine-flex-->
    </section>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>

    <script>
		$('.vitrine-flex').slick({
            dots: false,
            arrows:false,
            infinite: false,
            centerMode: false,
            speed:1000,
            slidesToShow: 4,
            autoplay: false,
            autoplaySpeed: 3000,
            pauseOnHover:false,
            responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3
                },
				breakpoint: 451,
				settings: {
					slidesToShow: 2
				},
            }]
	    });

		$('.vitrine-wraper').hover(function(){
			$(this).css('z-index','1000');
		})

		$('.vitrine-wraper').mouseout(function(){
			$(this).css('z-index','0');
        })

	</script>

@include('templates.footer')
@endsection

