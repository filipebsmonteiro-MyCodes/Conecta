<div class="top_nav">
	<div class="nav_menu">
		<nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>
			
			<ul class="nav navbar-nav navbar-right">
				<li class=""><a href="javascript:;"
					class="user-profile dropdown-toggle" data-toggle="dropdown"
					aria-expanded="false"> <img src="{{ url('imagens/Profile')}}/{{Auth::user()->idFoto or '1'}}.jpg"
						alt="">{{Auth::user()->first_name}} <span class=" fa fa-angle-down"></span>
				</a>
					<ul class="dropdown-menu dropdown-usermenu pull-right">
						<li><a href="{{route('membro.edit', Auth::user()->id)}}">
							<i class="fa fa-user fa-fw"></i> Profile</a></li>
						<li><a href="#" onclick="alert('Funcionalidade em Construção!');">
							<i class="fa fa-gear fa-fw"></i> Configurações</a></li>
						<li><a href="{{route('membro.alterarSenha')}}">
							<i class="fa fa-key fa-fw"></i> Alterar Senha</a>
						
						<li class="divider"></li>
						<li><a href="{{ route('logout') }}"
							onclick="event.preventDefault();
			                                                     document.getElementById('logout-form').submit();">
								<i class="fa fa-sign-out"></i> Log Out
						</a></li>
						<form id="logout-form" action="{{ route('logout') }}" method="POST"
							style="display: none;">{{ csrf_field() }}</form>
					</ul>
				</li>
			
				<li role="presentation" class="dropdown"><a href="javascript:;"
					class="dropdown-toggle info-number" data-toggle="dropdown"
					aria-expanded="false"> <i class="fa fa-envelope-o"></i> <span
						class="badge bg-red">6</span>
				</a>
					<ul id="menu1" class="dropdown-menu list-unstyled msg_list"
						role="menu">
						<li><a> <span> <span>John Smith</span> <span class="time">3 mins ago</span>
							</span> <span class="message"> Film festivals used to be do-or-die
									moments for movie makers. They were where... </span>
						</a></li>
						<li><a> <span> <span>John Smith</span> <span class="time">3 mins ago</span>
							</span> <span class="message"> Film festivals used to be do-or-die
									moments for movie makers. They were where... </span>
						</a></li>
						<li><a> <span> <span>John Smith</span> <span class="time">3 mins ago</span>
							</span> <span class="message"> Film festivals used to be do-or-die
									moments for movie makers. They were where... </span>
						</a></li>
						<li>
							<div class="text-center">
								<a> <strong>Veja Todos Alertas</strong> <i
									class="fa fa-angle-right"></i>
								</a>
							</div>
						</li>
					</ul>
			</ul>
			
		</nav>
	</div>
</div>