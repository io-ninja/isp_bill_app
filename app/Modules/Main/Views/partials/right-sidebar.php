<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center bg-dark p-3">
            <h5 class="m-0 me-2 text-white">Theme Customizer</h5>
            <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <hr class="m-0" />
        <div class="p-4">
            <!-- Layout Width -->
            <h6 class="mb-3">Layout Width</h6>
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="layout-width-switch" onchange="document.body.setAttribute('data-layout-size', this.checked ? 'fluid' : 'boxed')" checked>
                <label class="form-check-label" for="layout-width-switch">Fluid x Boxed</label>
            </div>

            <!-- Layout Position -->
            <h6 class="mt-4 mb-3 pt-2">Layout Position</h6>
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="layout-position-switch" onchange="document.body.setAttribute('data-layout-scrollable', this.checked ? 'false' : 'true')" checked>
                <label class="form-check-label" for="layout-position-switch">Fixed x Scrollable</label>
            <!-- </div>
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="layout-position-scrollable" value="scrollable" onchange="document.body.setAttribute('data-layout-scrollable', this.checked ? 'true' : 'false')">
                <label class="form-check-label" for="layout-position-scrollable">Scrollable</label> -->
            </div>

            <!-- Sidebar Size -->
            <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Sidebar Size</h6>
            <div class="form-check sidebar-setting">
                <input class="form-check-input" type="radio" name="sidebar-size" id="sidebar-size-default" value="default" onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                <label class="form-check-label" for="sidebar-size-default">Default</label>
            </div>
            <div class="form-check sidebar-setting">
                <input class="form-check-input" type="radio" name="sidebar-size" id="sidebar-size-compact" value="compact" onchange="document.body.setAttribute('data-sidebar-size', 'md')">
                <label class="form-check-label" for="sidebar-size-compact">Compact</label>
            </div>
            <div class="form-check sidebar-setting">
                <input class="form-check-input" type="radio" name="sidebar-size" id="sidebar-size-small" value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                <label class="form-check-label" for="sidebar-size-small">Small (Icon View)</label>
            </div>
        </div>
    </div>
</div>
<div class="rightbar-overlay"></div>