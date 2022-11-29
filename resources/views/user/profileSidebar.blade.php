<div class="card card-custom card-stretch" style="height:auto">
  <div class="card-body pt-4">
    <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
      <div class="navi-item mb-2">
        <a href="{{ route('users.profile', ['id' => $user->id]) }}" class="navi-link py-4 {{ $active == 'profile' ? 'active' : '' }}">
          <span class="navi-icon mr-2">
            <span class="svg-icon">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <polygon points="0 0 24 0 24 24 0 24" />
                  <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                  <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                </g>
              </svg>
            </span>
          </span>
          <span class="navi-text font-size-lg">Profile</span>
        </a>
      </div>
      <div class="navi-item mb-2">
        <a href="{{ route('users.password', ['id' => $user->id]) }}" class="navi-link py-4 {{ $active == 'password' ? 'active' : '' }}">
          <span class="navi-icon mr-2">
            <span class="svg-icon">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <mask fill="white">
                    <use xlink:href="#path-1"></use>
                  </mask>
                  <g></g>
                  <path d="M15.6274517,4.55882251 L14.4693753,6.2959371 C13.9280401,5.51296885 13.0239252,5 12,5 C10.3431458,5 9,6.34314575 9,8 L9,10 L14,10 L17,10 L18,10 C19.1045695,10 20,10.8954305 20,12 L20,18 C20,19.1045695 19.1045695,20 18,20 L6,20 C4.8954305,20 4,19.1045695 4,18 L4,12 C4,10.8954305 4.8954305,10 6,10 L7,10 L7,8 C7,5.23857625 9.23857625,3 12,3 C13.4280904,3 14.7163444,3.59871093 15.6274517,4.55882251 Z" fill="#000000"></path>
                </g>
              </svg>
            </span>
          </span>
          <span class="navi-text font-size-lg">Password</span>
        </a>
      </div>

      <div class="navi-item mb-2">
        <a href="{{ route('users.permission', ['id' => $user->id]) }}" class="navi-link py-4 {{ $active == 'permission' ? 'active' : '' }}">
          <span class="navi-icon mr-2">
            <span class="svg-icon">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <mask fill="white">
                    <use xlink:href="#path-1"></use>
                  </mask>
                  <g></g>
                  <path d="M15.6274517,4.55882251 L14.4693753,6.2959371 C13.9280401,5.51296885 13.0239252,5 12,5 C10.3431458,5 9,6.34314575 9,8 L9,10 L14,10 L17,10 L18,10 C19.1045695,10 20,10.8954305 20,12 L20,18 C20,19.1045695 19.1045695,20 18,20 L6,20 C4.8954305,20 4,19.1045695 4,18 L4,12 C4,10.8954305 4.8954305,10 6,10 L7,10 L7,8 C7,5.23857625 9.23857625,3 12,3 C13.4280904,3 14.7163444,3.59871093 15.6274517,4.55882251 Z" fill="#000000"></path>
                </g>
              </svg>
            </span>
          </span>
          <span class="navi-text font-size-lg">Permission</span>
        </a>
      </div>

    </div>
  </div>
</div>
