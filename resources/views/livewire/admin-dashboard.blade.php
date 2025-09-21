<div>
    <div class="grid gap-4 lg:grid-cols-2 mb-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-2.5">Welcome</h5>
                <p>Welcome to your admin dashboard.</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-2.5">Stats</h5>
                <div class="flex flex-wrap gap-2">
                    <div class="alert alert-primary" role="alert">Users: 100</div>
                    <div class="alert alert-secondary" role="alert">Sales: $1000</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-8">
        <div class="card-body">
            <h5 class="card-title mb-2.5">Recent Orders</h5>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#12345</td>
                            <td>John Doe</td>
                            <td>Laptop</td>
                            <td>$1200</td>
                            <td><span class="badge badge-success">Delivered</span></td>
                        </tr>
                        <tr>
                            <td>#12346</td>
                            <td>Jane Smith</td>
                            <td>Mouse</td>
                            <td>$25</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>#12347</td>
                            <td>Peter Jones</td>
                            <td>Keyboard</td>
                            <td>$75</td>
                            <td><span class="badge badge-error">Cancelled</span></td>
                        </tr>
                        <tr>
                            <td>#12348</td>
                            <td>Alice Brown</td>
                            <td>Monitor</td>
                            <td>$300</td>
                            <td><span class="badge badge-success">Delivered</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2 mb-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-2.5">Buttons</h5>
                <div class="flex flex-wrap gap-2">
                    <button class="btn">Default</button>
                    <button class="btn btn-primary">Primary</button>
                    <button class="btn btn-secondary">Secondary</button>
                    <button class="btn btn-accent">Accent</button>
                    <button class="btn btn-info">Info</button>
                    <button class="btn btn-success">Success</button>
                    <button class="btn btn-warning">Warning</button>
                    <button class="btn btn-error">Error</button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-2.5">Badges</h5>
                <div class="flex flex-wrap gap-2">
                    <span class="badge">Default</span>
                    <span class="badge badge-primary">Primary</span>
                    <span class="badge badge-secondary">Secondary</span>
                    <span class="badge badge-accent">Accent</span>
                    <span class="badge badge-info">Info</span>
                    <span class="badge badge-success">Success</span>
                    <span class="badge badge-warning">Warning</span>
                    <span class="badge badge-error">Error</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-8">
        <div class="card-body">
            <h5 class="card-title mb-2.5">Alerts</h5>
            <div class="space-y-2">
                <div class="alert alert-primary" role="alert">Stay tuned for our upcoming events and announcements.</div>
                <div class="alert alert-primary alert-soft" role="alert">
                    Your transaction was successful. Thank you for choosing our service!
                </div>
                <div class="alert alert-primary alert-outline" role="alert">
                    Attention! Your account security may be at risk. Enable two-factor authentication now.
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-2.5">Modal Demo</h5>
            <div>
                <button type="button" class="btn btn-primary" aria-haspopup="dialog" aria-expanded="false" aria-controls="basic-modal" data-overlay="#basic-modal" >
                  Open modal
                </button>
                <div id="basic-modal" class="overlay modal overlay-open:opacity-100 overlay-open:duration-300 hidden" role="dialog" tabindex="-1" >
                  <div class="modal-dialog overlay-open:opacity-100 overlay-open:duration-300">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h3 class="modal-title">Dialog Title</h3>
                        <button
                          type="button"
                          class="btn btn-text btn-circle btn-sm absolute end-3 top-3"
                          aria-label="Close"
                          data-overlay="#basic-modal"
                        >
                          <span class="icon-[tabler--x] size-4"></span>
                        </button>
                      </div>
                      <div class="modal-body"> This is some placeholder content to show the scrolling behavior for modals. Instead of repeating the text in the modal, we use an inline style to set a minimum height, thereby extending the length of the overall modal and demonstrating the overflow scrolling. When content becomes longer than the height of the viewport, scrolling will move the modal as needed. </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-soft btn-secondary" data-overlay="#basic-modal">
                          Close
                        </button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>