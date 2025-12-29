<div class="col-12 col-xl-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-info-circle me-2"></i>
                Template Variables Guide
            </h6>
        </div>
        <div class="card-body">
            <p class="small text-muted mb-3">
                Use these common variable patterns in your email templates:
            </p>

            <div class="mb-3">
                <h6 class="small fw-bold">User Variables:</h6>
                <code class="small d-block">@{{ $user_name }}</code>
                <code class="small d-block">@{{ $user_email }}</code>
                <code class="small d-block">@{{ $user_phone }}</code>
            </div>

            <div class="mb-3">
                <h6 class="small fw-bold">System Variables:</h6>
                <code class="small d-block">@{{ $app_name }}</code>
                <code class="small d-block">@{{ $app_url }}</code>
                <code class="small d-block">@{{ $current_date }}</code>
            </div>

            <div class="mb-3">
                <h6 class="small fw-bold">Action Variables:</h6>
                <code class="small d-block">@{{ $verification_link }}</code>
                <code class="small d-block">@{{ $reset_link }}</code>
                <code class="small d-block">@{{ $login_url }}</code>
            </div>

            <div class="alert alert-info p-2 small">
                <i class="fas fa-lightbulb me-1"></i>
                <strong>Tip:</strong> Use the "Variable" button in the editor toolbar to quickly insert variables.
            </div>

            <hr class="my-4">

            <h6 class="card-title mb-2">
                <i class="fas fa-question-circle me-2"></i>
                How to Use These Templates
            </h6>
            <p class="small text-muted mb-3">
                When you send an email using these templates, Laravel will automatically replace the variables with actual data.
            </p>

            <div class="mb-3">
                <h6 class="small fw-bold">1. Storing Your Template:</h6>
                <p class="small">
                    Save the content of your email template (e.g., from the editor) to your database. This content is effectively raw Blade syntax.
                </p>
                <p class="small">
                    Example:
                    <code class="d-block small text-wrap bg-light p-2 rounded">
                        Hello, @{{ $user_name }}! Welcome to @{{ $app_name }}.
                    </code>
                </p>
            </div>

            <div class="mb-3">
                <h6 class="small fw-bold">2. Sending the Email in Laravel:</h6>
                <p class="small">
                    You'll typically fetch the template content from your database and then use Laravel's Mailables or the `Mail` facade to send it. The key is to pass the variables (e.g., `user_name`, `app_name`) that you want to be replaced in the template.
                </p>
                <p class="small">
                    Laravel will render this content using its Blade engine, substituting your provided data.
                </p>
            </div>

            <div class="mb-3">
                <h6 class="small fw-bold">Example in your PHP code (e.g., in a Mailable or Controller):</h6>
                <pre class="bg-light p-2 rounded small"><code>
                        use Illuminate\Support\Facades\Mail;
                        use Illuminate\Support\Facades\Blade; // If rendering dynamically
                        use App\Models\EmailTemplate; // Make sure to import your EmailTemplate model

                        // Assuming you fetch your template from the database
                        $emailTemplateContent = EmailTemplate::where('slug', 'welcome-email')->first()->content;

                        // Data to be passed to the template
                        $data = [
                            'user_name' => 'John Doe',
                            'user_email' => 'john@example.com',
                            'app_name' => config('app.name'),
                            'app_url' => url('/'),
                            // ... other variables you define
                        ];

                        // Option A: Using Blade::render() for dynamic content (most common for DB templates)
                        $renderedContent = Blade::render($emailTemplateContent, $data);

                        // Now send the email
                        Mail::raw($renderedContent, function ($message) use ($data) {
                            $message->to($data['user_email'])
                                    ->subject('Welcome to ' . $data['app_name']);
                        });

                        /*
                        // Option B: If you're building a Mailable class, you'd usually pass
                        // the variables to the Mailable and construct the view:
                        // class WelcomeUser extends Mailable
                        // {
                        //    public $userName;
                        //
                        //    public function __construct($userName)
                        //    {
                        //        $this->userName = $userName;
                        //    }
                        //
                        //    public function build()
                        //    {
                        //        return $this->html(EmailTemplate::where('slug', 'welcome')->first()->content)
                        //                    ->with(['user_name' => $this->userName]);
                        //    }
                        // }
                        //
                        // Mail::to($user->email)->send(new WelcomeUser($user->name));
                        */
                </code></pre>
            </div>

            <div class="alert alert-warning p-2 small">
                <i class="fas fa-exclamation-triangle me-1"></i>
                <strong>Important:</strong> Ensure your code correctly passes the variables (e.g., `$user_name`, `$app_name`) as data to the Blade rendering engine when sending the email. The variable names in your code must match the placeholders in your template.
            </div>
        </div>
    </div>
</div>