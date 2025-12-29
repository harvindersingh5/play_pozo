$(document).ready(function() {
    const $form = $('form');
    const $formElements = $form.find('input, textarea, select');
    let isFormModified = false;
    let navigationConfirmed = false;

    $formElements.on('input change', function() {
        console.log('changed');
        isFormModified = true;
    });

    $(document).on('quill-content-changed', function() {
        isFormModified = true;
    });

    $('.nav-link').on('click', function(event) {
        console.log('nav-link clicked');
        if (!isFormModified) return; // No need to show alert if no changes were made
        event.preventDefault();
        const targetUrl = $(this).attr('href');
        if (isFormModified && !navigationConfirmed) {
            showUnsavedChangesAlert(targetUrl);
        } else if (navigationConfirmed) {
            window.location.href = targetUrl;
        }
    });

    $(window).on('beforeunload', function(event) {
        if (isFormModified && !navigationConfirmed) {
            event.preventDefault();
            return "";
        }
        return undefined;
    });

    function showUnsavedChangesAlert(targetUrl = null) {
        Swal.fire({
            title: "Leave this page?",
            text: "You have unsaved changes that will be lost.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Leave",
            cancelButtonText: "No, Stay",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                navigationConfirmed = true; 
                if (targetUrl) {
                    window.location.href = targetUrl;
                } else {
                    window.history.back();
                }
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                navigationConfirmed = false;
            }
        });
    }

    $form.on('submit', function() {
        isFormModified = false;
        navigationConfirmed = false;
    });
});