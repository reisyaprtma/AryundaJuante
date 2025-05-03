                    <li class="nav-item">
                        <a class="nav-link {{ str_contains(request()->url(), 'jobs-management') == true ? 'active' : '' }}" href="{{ route('admin.jobs-management') }}">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>credit-card</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(453.000000, 454.000000)">
                                                    <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                                    <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="nav-link-text ms-1">Manajemen Pekerjaan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ str_contains(request()->url(), 'completed-jobs') == true ? 'active' : '' }}" href="{{ route('admin.completed-jobs') }}">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>box-3d-50</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(603.000000, 0.000000)">
                                                    <path class="color-background" d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,11.0173342 39.592906,10.5222851 39.3707167,10.0283063 C39.1654837,9.57729983 38.7301641,9.37367323 38.2740877,9.50319735 L10.8598034,17.7298012 C9.40578162,18.1442057 8.7426469,19.7290816 9.1570514,21.1831034 C9.52563753,22.5038007 10.8110317,23.3324194 12.1446992,23.3324194 L15.0267066,23.3324194 L15.0267066,24.7984745 L15.0267066,24.7984745 C15.0267066,25.4737899 15.5751299,26.0222132 16.2504453,26.0222132 C16.9257607,26.0222132 17.474184,25.4737899 17.474184,24.7984745 L17.474184,23.3324194 L20.3561914,23.3324194 C21.5115452,23.3324194 22.5281372,22.5822926 22.7597136,21.4588093 L24.6980521,14.7417115 C24.8782705,13.9126635 24.7626248,13.0633484 24.3707058,12.3233973 C24.0047897,11.6341969 23.444656,11.0627527 22.7597136,10.7210182 L22.7597136,19.3090182 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="nav-link-text ms-1">History Pekerjaan Selesai</span>
                        </a>
                    </li>
