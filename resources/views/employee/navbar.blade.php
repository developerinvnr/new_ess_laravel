                        <div class="user-info-wrapper header-links">        
                            <a href="javascript:void(0);" class="user-info">
                                <!-- <img src="./images/user.jpg" alt="" class="user-img"> -->
                                <!-- <img class="user-img" src="{{ asset('employeeimages/' . Auth::user()->employeephoto->EmpPhotoPath) }}"
                                alt="user-img"> -->
                                <img src="https://eu.ui-avatars.com/api/?name={{ Auth::user()->Fname }}&background=A585A3&color=fff&bold=true&length=1&font-size=0.5"
                                alt="user-img">
                                
                            </a>
                            <div class="user-info-box">
                                <div class="drop-down-header">
                                    <h4>{{ Auth::user()->Fname . ' ' . Auth::user()->Sname . '' . Auth::user()->Lname }}</h4>
                                    <p>{{ ucwords(strtolower(Auth::user()->designation->DesigName ?? 'No Designation')) }}</p>
                                    <p>Emp. Code - {{ Auth::user()->EmpCode}}</p>
                                </div>
                                <ul>
                                    <li>
                                        <a href="{{ route('profile') }}">
                                            <i class="far fa-user"></i> Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin.html">
                                            <i class="fas fa-cog"></i> Admin
                                        </a>
                                    </li>
                                    <li>
                                    <a href="{{ route(name: 'change-password') }}">
                                    <i class="fas fa-cog"></i> Change Passward
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-1').submit();">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </a>
                                        <form id="logout-form-1" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>