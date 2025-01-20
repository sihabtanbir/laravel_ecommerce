<ul class="account-nav">
            <li><a href="{{route('user.index')}}" class="menu-link menu-link_us-s">Dashboard</a></li>
            <li><a href="#" class="menu-link menu-link_us-s">Orders</a></li>
            <li><a href="#" class="menu-link menu-link_us-s">Addresses</a></li>
            <li><a href="#" class="menu-link menu-link_us-s">Account Details</a></li>
            <li><a href="#" class="menu-link menu-link_us-s">Wishlist</a></li>
            <li >
                 <form action="{{route('logout')}}" id="logout-form" method="POST" >
                     @csrf
                    <a href="{{route('logout')}}" class="" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                       <div class="icon"><i class="bi bi-box-arrow-right"></i></div>
                         <div class="text">Logout</div>
                    </a>
                   </form>
            </li>
          </ul>