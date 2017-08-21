

<div class="col-md-3 left_col">
	<div class="left_col scroll-view">
	
		<div class="navbar nav_title" 
		style="
		    background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #2b313c), color-stop(100%, #1b1d23));
		    background-image: -moz-linear-gradient(#2b313c, #1b1d23);
		    background-image: -webkit-linear-gradient(#2b313c, #1b1d23);
		    background-image: linear-gradient(#2b313c, #1b1d23);
		">
			<a href="{{route('home.index')}}" class="site_title"><i
				class="fa fa-bank"></i> <span>Conecta</span></a>
		</div>
	
		<div class="clearfix"></div>
		
		<!-- menu profile quick info -->
		<div class="profile clearfix">
			<div class="profile_pic">
				<img src="{{ url('imagens/Profile')}}/{{Auth::user()->idFoto or '1'}}.jpg" alt="..."
					class="img-circle profile_img">
			</div>
			<div class="profile_info">
				<span>Bem Vindo(a), </span>
				<h2>{{Auth::user()->first_name}}</h2>
			</div>
		</div>
		<!-- /menu profile quick info -->
	
		<!-- sidebar menu -->
		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
			<div class="menu_section">
		
				<ul class="nav side-menu" id="side-menu">
		
					<li><a href="{{route('home.index')}}"><i class="fa fa-home fa-fw"></i>
							Home</a></li>
					
					<li><a href="{{route('evento.index')}}"><i
							class="fa fa-pencil fa-fw"></i> Eventos</a></li>
		
					@can('membro_list')
					<li><a href="{{route('membro.index')}}"><i class="fa fa-users fa-fw"></i>
							Membros</a></li>
					@endcan
		
					@can('convidado_list')
					<li><a href="{{route('convidado.index')}}"><i
							class="fa fa-umbrella fa-fw"></i> Convidados</a></li>
					@endcan
		
					@can('celula_list')
					<li><a href="{{route('celula.index')}}"><i
							class="fa  fa-leaf fa-fw"></i> Células</a></li>
					@endcan
		
					@can('regiao_list')
					<li><a href="{{route('regiao.index')}}"><i
							class="fa fa-area-chart fa-fw"></i> Regiões</a></li>
					@endcan
		
				</ul>
		
			</div>
		
		</div>
		<!-- /sidebar menu -->
	</div>
</div>