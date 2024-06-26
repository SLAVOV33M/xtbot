<div class="navbar-custom">
    <div class="container-fluid">
        <div id="navigation">
            <ul class="navigation-menu">
                <li class="has-submenu">
                    <a href="{{ route('panel') }}"><i class="ti-home"></i>Dashboard</a>
                </li>
                <li class="has-submenu">
                    <a href="#"><i class="ti-settings"></i>Bot</a>
                    <ul class="submenu">
                        <li><a href="{{ route('bot.edit') }}">General Settings</a></li>
                        <li class="has-submenu">
                            <a href="#">Lists</a>
                            <ul class="submenu">
                                <li><a href="{{ route('bot.staff') }}">Staff</a></li>
                                <li><a href="{{ route('bot.autotemp') }}">AutoTemp</a></li>
                                <li><a href="{{ route('bot.snitch') }}">Snitch</a></li>
                                <li><a href="{{ route('bot.autoban') }}">AutoBan</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#">Behavior Manager</a>
                            <ul class="submenu">
                                <li><a href="{{ route('bot.response') }}">Responses</a></li>
                                <li><a href="{{ route('bot.badword') }}">Bad Words</a></li>
                                <li><a href="{{ route('bot.link') }}">Link Filter</a></li>
                                <li><a href="{{ route('bot.botlang') }}">Bot Messages</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#">Command Manager</a>
                            <ul class="submenu">
                                <li><a href="{{ route('bot.minrank') }}">Minranks</a></li>
                                <li><a href="{{ route('bot.alias') }}">Aliases</a></li>
                                <li><a href="{{ route('bot.customcmd') }}">Custom commands</a></li>
                            </ul>
                        </li>

                        <li><a href="{{ route('bot.powers') }}">Bot Powers</a></li>
{{--                        <li><a href="{{ route('bot.logs', Session('onBotEdit')) }}">Chat Logs</a></li>--}}
                        <li><a href="{{ route('sharebot') }}">Share bot</a></li>
                        <li><a href="{{ route('bot.statistics') }}">Staff Statistics</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#"><i class="ti-file"></i>Pages</a>
                    <ul class="submenu">
                        <li><a href="{{ route('chat') }}">Chat</a></li>
                        <li><a href="{{ route('commands', Session('onBotEdit')) }}">Commands</a></li>
                        <li><a href="{{ route('tags') }}">Tags</a></li>
                        <li><a href="{{ route('setupbot') }}">Set up your bot</a></li>
                        <li><a href="{{ route('getpremium') }}">Get Premium</a></li>
                        <li><a href="{{ route('staff') }}">Staff</a></li>
                        <li><a href="{{ route('userinfo') }}">Userinfo</a></li>
                        <li><a href="{{ route('servers') }}">Servers</a></li>
                        <li><a href="{{ route('everymissing') }}">Everymissing</a></li>
                        <li><a href="{{ route('allmissing') }}">Allmissing</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="{{ route('support.list') }}"><i class="ti-help"></i>Support</a>
                </li>
                @level(3)
                <li class="has-submenu">
                    <a href="#"><i class="ti-rocket"></i>Staff</a>
                    <ul class="submenu">
                        <li><a href="{{ route('staff.bots') }}">Bots</a></li>
                        <li><a href="{{ route('staff.users') }}">Users</a></li>
                        <li><a href="{{ route('staff.tickets') }}">Tickets</a></li>
                        @role('Admin')
                        <li><a href="{{ route('staff.botmessages') }}">Bot Messages</a></li>
                        <li><a href="{{ route('staff.commands') }}">Commands</a></li>
                        <li><a href="{{ route('staff.servers') }}">Servers</a></li>
                        <li><a href="{{ route('staff.languages') }}">Languages</a></li>
                        @endrole
                    </ul>
                </li>
                @endlevel
            </ul>
        </div>
    </div>
</div>
