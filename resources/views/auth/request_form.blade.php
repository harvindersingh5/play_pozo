<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="shortcut icon" href="{{ asset('custom-design/images/logo1.png') }}" type="image/x-icon"> --}}
    <title>Support</title>
    <style>
        /* General body styling */
        body {
            font-family: 'Inter', sans-serif;
            /* Using Inter font */
            background-color: #f0f2f5;
            /* Light grey background */
            color: #333;
            /* Dark grey text */
            line-height: 1.6;
            margin: 0;
            padding: 0;
            display: flex;
            /* Use flexbox for centering */
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            min-height: 100vh;
            /* Full viewport height */
        }

        /* Section for the contact form */
        .contact-section {
            background-color: #fff;
            padding: 40px 0;
            width: 100%;
            /* Take full width of parent */
            max-width: 900px;
            /* Max width for larger screens */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            /* Soft shadow */
            border-radius: 12px;
            /* More rounded corners */
            overflow: hidden;
            /* Ensure shadow is contained */
        }

        /* Wrapper for content within the section */
        .contact-wrapper {
            width: 90%;
            /* Slightly wider internal wrapper */
            margin: 0 auto;
            padding: 30px;
            text-align: center;
        }

        /* Inner content area for the form */
        .contact-form-container {
            background-color: #f9fbfd;
            /* Very light blue-grey */
            padding: 30px;
            border-radius: 10px;
            /* Rounded corners for the form container */
            text-align: left;
        }

        .contact-form-container h1 {
            font-size: 32px;
            color: #2c3e50;
            /* Darker blue-grey for heading */
            margin-bottom: 10px;
            /* Adjusted margin for subheading */
            text-align: center;
            text-transform: uppercase;
            /* Uppercase for "SUPPORT" */
        }

        .contact-form-container h2 {
            /* New style for the subheading */
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 15px;
            text-align: center;
        }

        .contact-form-container p.support-message {
            /* Style for the descriptive text */
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
            text-align: center;
            line-height: 1.5;
        }

        /* Form group for labels and inputs */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
            color: #555;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group textarea {
            width: calc(100% - 20px);
            /* Full width minus padding */
            padding: 12px 10px;
            border: 1px solid #dcdfe6;
            /* Light grey border */
            border-radius: 6px;
            /* Slightly rounded input fields */
            font-size: 16px;
            color: #333;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
            /* Include padding in width */
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group textarea:focus {
            border-color: #3498db;
            /* Blue on focus */
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            /* Soft blue shadow on focus */
            outline: none;
            /* Remove default outline */
        }

        .form-group textarea {
            resize: vertical;
            /* Allow vertical resizing */
            min-height: 120px;
            /* Minimum height for textarea */
        }

        /* Submit button styling */
        .submit-button {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #000000;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Green shadow */
        }

        .submit-button:hover {
            background-color: #000000;
            transform: translateY(-2px);
            /* Slight lift effect */
        }

        .submit-button:active {
            transform: translateY(0);
            /* Press down effect */
            box-shadow: 0 2px 4px rgba(3, 10, 5, 0.3);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .contact-wrapper {
                width: 95%;
                padding: 20px;
            }

            .contact-logo img {
                max-width: 150px;
            }

            .contact-form-container h1 {
                font-size: 28px;
                /* Adjusted for smaller screens */
            }

            .contact-form-container h2 {
                font-size: 20px;
            }

            .contact-form-container p.support-message {
                font-size: 14px;
            }

            .form-group input[type="text"],
            .form-group input[type="email"],
            .form-group textarea {
                width: calc(100% - 20px);
                /* Maintain padding */
            }
        }

        @media (max-width: 480px) {
            .contact-section {
                padding: 20px 0;
            }

            .contact-wrapper {
                padding: 15px;
            }

            .contact-form-container {
                padding: 20px;
            }

            .contact-form-container h1 {
                font-size: 24px;
            }

            .contact-form-container h2 {
                font-size: 18px;
            }

            .contact-form-container p.support-message {
                font-size: 13px;
            }

            .form-group input[type="text"],
            .form-group input[type="email"],
            .form-group textarea {
                font-size: 14px;
                padding: 10px;
            }

            .submit-button {
                font-size: 16px;
                padding: 12px;
            }
        }

        /* Additional styles for error messages */
        .text-danger {
            color: #e74c3c;
            /* Red color for error messages */
            font-size: 14px;
            margin-top: 5px;
        }

        .iziToast>.iziToast-body .iziToast-title {
            line-height: 16px !important;
            font-size: 14px !important;
        }

        .iziToast>.iziToast-body .iziToast-message {
            line-height: 16px !important;
            font-size: 14px !important;
        }

        .alert-message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 16px;
            text-align: center;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
            position: relative;
            /* Needed for positioning the close button */
        }

        .alert-message.success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-message.error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-message.validation-errors {
            background-color: #f8d7da; /* Changed to light red */
            color: #721c24; /* Changed to dark red text */
            border: 1px solid #f5c6cb; /* Changed to red border */
            text-align: left;
        }

        .alert-message.validation-errors ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .alert-message.validation-errors li {
            margin-bottom: 5px;
        }

        /* Style for the dismiss button */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            color: inherit;
            /* Inherit color from parent message */
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-btn:hover {
            color: #000;
            /* Darken on hover */
        }
    </style>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script> --}}
</head>

<body>
    <section class="contact-section">
        <div class="contact-wrapper">
            <div class="contact-logo">
                {{-- <img src="{{ asset('custom-design/images/logo_tc.png') }}" alt="logo" width="275px"
                    class="email-verify-logo"> --}}
            </div>
            <div class="contact-form-container">
                <h1>SUPPORT</h1>
                <h2>Send us a message</h2>
                <p class="support-message">We'll do our best to get back to you as quickly as possible - but please
                    allow for up to 2 business days for a response.</p>
                <form action="{{ route('send.message') }}" method="POST" id="contact-form">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Name" >
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email" >
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="Subject" >
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" placeholder="Message" ></textarea>
                    </div>
                    <button type="submit" class="submit-button">Send Message</button>
                </form>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#contact-form').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2,
                        maxlength: 50,
                    },
                    email: {
                        required: true,
                        email: true,
                        regex: /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i,
                    },
                    subject: {
                        required: true,
                        minlength: 2,
                        maxlength: 100,
                    },
                    message: {
                        required: true,
                        minlength: 10,
                        maxlength: 500,
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        minlength: "Your name must be at least 2 characters long",
                        maxlength: "Your name must not exceed 50 characters",
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address",
                        regex: "Please enter a valid email address",
                    },
                    subject: {
                        required: "Please enter a subject",
                        minlength: "Subject must be at least 2 characters long",
                        maxlength: "Subject must not exceed 100 characters",
                    },
                    message: {
                        required: "Please enter your message",
                        minlength: "Message must be at least 10 characters long",
                        maxlength: "Message must not exceed 500 characters",
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                },
                errorElement: 'span',
                errorClass: 'text-danger',
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                }
            });

            $.validator.addMethod("regex", function(value, element, pattern) {
                return this.optional(element) || pattern.test(value);
            }, "Please check your input.");
        });
    </script>
</body>

</html>
