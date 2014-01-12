<div id="visio">
    <div id="log">
    
    </div>
	<video autoplay="true" id="remote-video">
	
	</video>
	<video autoplay="true" id="local-video">
	
	</video>

    <div id="avatar">
        <img src="{$avatar}"/>
        <span class="name">{$name}</span>
    </div>
    <div class="menu">
        <a id="call" class="button color green merged left icon call">
            Call</a>
        <a id="hang-up" class="button color red merged right icon hang-up">
            Hang Up</a>

        <a id="toggle-screen" class="button icon expand color blue alone"></a>
    </div>
</div>
<script type="text/javascript">
    VISIO_JID = '{$jid}';
    VISIO_RESSOURCE = '{$ressource}';
</script>
<div id="connection">
	{$c->t('Connection')}...
</div>
