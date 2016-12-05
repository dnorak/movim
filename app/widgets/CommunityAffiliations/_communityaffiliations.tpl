{if="$role == 'owner'"}
    <ul class="list active">
        <li onclick="Group_ajaxGetConfig('{$item->server|echapJS}', '{$item->node|echapJS}')">
            <span class="primary icon gray">
                <i class="zmdi zmdi-settings"></i>
            </span>
            <p class="normal">{$c->__('group.configuration')}</p>
        </li>
        <li onclick="Group_ajaxGetSubscriptions('{$item->server|echapJS}', '{$item->node|echapJS}', true)">
            <span class="primary icon gray">
                <i class="zmdi zmdi-accounts-list"></i>
            </span>
            <p class="normal">{$c->__('group.subscriptions')}</p>
        </li>
        <li onclick="Group_ajaxDelete('{$item->server|echapJS}', '{$item->node|echapJS}')">
            <span class="primary icon gray">
                <i class="zmdi zmdi-delete"></i>
            </span>
            <p class="normal">{$c->__('button.delete')}</p>
        </li>
    </ul>
{/if}