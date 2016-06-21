<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>{$Title}</title>
		<meta name="robots" content="noindex, nofollow">
	</head>
	<body class="{$Environment}">

		<header>
			<h1>{$Environment} mode</h1>
		</header>

		<main>
			<div class="grid grid-pad">

    			<div class="col-1-3">
					<span class="pill"><strong>Mailer</strong> {$Mailer}</span>
				</div>
				<div class="col-1-3">
					<span class="pill"><strong>No follow</strong> <% if $Nofollow %>Active<% else_if Environment == 'dev' %>dev mode<% else %>Not found<% end_if %></span>
				</div>
				<div class="col-1-3">
					<span class="pill"><strong>Admin Email</strong> <% if $AdminEmail %>{$AdminEmail}<% else %>No set<% end_if %></span>
				</div>

				<div class="col-1-3">
					<span class="pill"><strong>Sending All Emails To</strong> $SendAllEmailsTo</span>
				</div>
				<div class="col-1-3">
					<span class="pill"><strong>Logging</strong> <% if $Logging %>Enabled<% else %>Not configured, please configure.<% end_if %></span>
				</div>
				<div class="col-1-3">
					<span class="pill"><strong>SiteMap</strong> <% if $SiteMap %>Enabled<% else %>Not found (404)<% end_if %></span>
				</div>

			</div>
			<% if $Logging %>
			<div class="grid grid-pad">

				<div class="col-1-1">
					<span class="pill">
						<strong class="text-left">Logs Enabled</strong>
						<ul>
						<% loop $Logging %>
						<li>{$Pos}. $Type ({$Details})</li>
						<% end_loop %>
						</ul>
					</span>
				</div>
			</div>
			<% end_if %>

			<% if $Lastcommit %>
			<div class="grid grid-pad">
				<div class="col-1-1">
					<span class="pill">
						<strong class="text-left">Last commit</strong> <ul><li>{$LastCommit}</li></ul>
					</span>
				</div>
			</div>
			<% end_if %>

			<div class="clear">&nbsp;</div>
		</main>

	</body>
</html>
