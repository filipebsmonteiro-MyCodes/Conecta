@extends('layouts.app') @section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Versículo do Dia</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-sm-12">

						<script
							src="//assets.gospelmais.com.br/webmasters/versiculos/?verse_size=15px&book_size=12px&verse_color=006699&book_color=666666&font_name=Tahoma&box_padding=7px&box_border=DADADA&box_background=F2F2F2&livros=Gn,Ex,Lv,Nm"
							type="text/javascript"></script>
						<br> <br>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection
