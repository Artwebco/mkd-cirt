document.addEventListener("DOMContentLoaded", function () {
  const toggle = document.getElementById("menu-toggle");
  const menu = document.querySelector(".main-navigation");

  toggle.addEventListener("click", function () {
    toggle.classList.toggle("active"); // for the hamburger animation
    menu.classList.toggle("active");   // to show/hide the menu
  });
});

//Form ID 1
jQuery(function ($) {
  $(document).on('gform_post_render', function (event, formId) {
    if (formId === 1) {
      const $form = $('#gform_' + formId);

      if (!$form.find('.left-column').length && !$form.find('.right-column').length) {
        const $leftColumn = $('<div class="left-column"></div>');
        const $rightColumn = $('<div class="right-column"></div>');
        const $wrapper = $('<div class="wrapper"></div>');

        $leftColumn
          .append($('#input_' + formId + '_1').closest('.gfield'))
          .append($('#input_' + formId + '_2').closest('.gfield'))
          .append($('#input_' + formId + '_3').closest('.gfield'))
          .append($('#input_' + formId + '_4').closest('.gfield'))
          .append($('#input_' + formId + '_5').closest('.gfield'));

        $rightColumn
          .append($('#field_' + formId + '_6'))
          .append($('#field_' + formId + '_7'))
          .append($('#field_' + formId + '_12'))
          .append($form.find('.gform_footer'));

        $wrapper.append($leftColumn).append($rightColumn);

        $('#gform_fields_' + formId).before($wrapper);
      }
    }
  });
});

//Form ID 5
jQuery(function ($) {
  function layoutForm5() {
    const formId = 5;
    const $form = $('#gform_' + formId);
    if (!$form.length || $form.find('.left-column').length) return;

    const $leftColumn = $('<div class="left-column"></div>');
    const $rightColumn = $('<div class="right-column"></div>');
    const $wrapper = $('<div class="wrapper"></div>');

    $leftColumn
          .append($('#input_' + formId + '_6').closest('.gfield'))
          .append($('#input_' + formId + '_5').closest('.gfield'))
          .append($('#input_' + formId + '_3').closest('.gfield'))
          .append($('#input_' + formId + '_1').closest('.gfield'))

    $rightColumn
          .append($('#field_' + formId + '_13'))
          .append($('#field_' + formId + '_7'))
      .append($form.find('.gform_footer'));

    $wrapper.append($leftColumn).append($rightColumn);

    $('#gform_fields_' + formId).before($wrapper);
  }

  // Hook to Gravity Form's rendering
  $(document).on('gform_post_render', function (event, formId) {
    if (formId === 5) {
      layoutForm5();
    }
  });

  // Also trigger manually when tab is clicked
  $('#your-tab-button-selector').on('click', function () {
    setTimeout(layoutForm5, 100); // wait a bit in case form renders after tab click
  });
});


document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('search-toggle');
    const closeBtn = document.getElementById('close-search');
    const modal = document.getElementById('search-modal');

    toggleBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
        modal.classList.remove('active');
        modal.classList.add('hidden');
    });

    // Optional: Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === "Escape") {
            modal.classList.remove('active');
            modal.classList.add('hidden');
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#projects-table tbody');

    if (tableBody) {
        tableBody.addEventListener('click', function (e) {
            // Prevent clicks on inner <a> or <button> elements
            if (!e.target.closest('a') && !e.target.closest('button')) {
                const row = e.target.closest('tr');
                if (row && row.dataset.href) {
                    window.location.href = row.dataset.href;
                }
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#projects-table tbody tr').forEach(row => {
        const tooltip = row.querySelector('.hover-tooltip');
        const tdContainer = tooltip ? tooltip.parentElement : null;

        row.addEventListener('mousemove', e => {
            if (!tooltip || !tdContainer) return;

            tooltip.style.opacity = '1';
            tooltip.style.visibility = 'visible';

            const rect = tdContainer.getBoundingClientRect();
            const offsetX = e.clientX - rect.left;
            const offsetY = e.clientY - rect.top;

            tooltip.style.left = offsetX + 'px';
            tooltip.style.top = (offsetY - 30) + 'px';
            tooltip.style.transform = 'translateX(-50%)';
        });

        row.addEventListener('mouseleave', () => {
            if (!tooltip) return;
            tooltip.style.opacity = '0';
            tooltip.style.visibility = 'hidden';
        });
    });
});

//When click on Пријави инцидент redirect to home page and scroll down to the form
// document.addEventListener("DOMContentLoaded", function () {
//   const incidentButton = document.querySelector('.incident-button a');

//   if (incidentButton) {
//     incidentButton.addEventListener('click', function (e) {
//       e.preventDefault();
//       const targetId = '#online-application';

//       if (window.location.pathname === '/') {
//         const targetElement = document.querySelector(targetId);
//         if (targetElement) {
//           targetElement.scrollIntoView({ behavior: 'smooth' });
//         }
//       } else {
//         // Redirect with a custom flag to trigger smooth scroll
//         sessionStorage.setItem('scrollToOnlineApplication', 'true');
//         window.location.href = '/' + targetId;
//       }
//     });
//   }

//   // After redirect, handle smooth scroll manually
//   if (window.location.hash === '#online-application' && sessionStorage.getItem('scrollToOnlineApplication') === 'true') {
//     sessionStorage.removeItem('scrollToOnlineApplication');

//     // Prevent native jump and smooth scroll instead
//     setTimeout(() => {
//       const targetElement = document.querySelector('#online-application');
//       if (targetElement) {
//         targetElement.scrollIntoView({ behavior: 'smooth' });
//       }
//     }, 300); // delay ensures DOM is ready
//   }
// });


//Services page
document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.service-card');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const domain = btn.getAttribute('data-domain');

            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            cards.forEach(card => {
                const domains = card.getAttribute('data-domains').split(' ');
                if (domain === 'all' || domains.includes(domain)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
  const targetId = '#menu-second-menu';
  const menuLinks = document.querySelectorAll('#menu-second-menu a');

  // Debug: Log menu links count
  //console.log('Found menu links:', menuLinks.length);

  menuLinks.forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();

      const targetUrl = new URL(link.href);
      const targetPath = targetUrl.pathname;
      const currentPath = window.location.pathname;

     //console.log('Clicked link to:', targetUrl.href);
      //console.log('Current path:', currentPath);

      if (targetPath === currentPath) {
        // Same page — scroll smoothly immediately
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          console.log('Scrolling to menu on same page');
          targetElement.scrollIntoView({ behavior: 'smooth' });
        }
      } else {
        // Different page — set flag and redirect with hash
        sessionStorage.setItem('scrollToMenu', 'true');
        const redirectUrl = targetPath + targetId;
        console.log('Redirecting to:', redirectUrl);
        window.location.href = redirectUrl;
      }
    });
  });

// On page load, check if hash and flag are set to scroll
if (window.location.hash === targetId && sessionStorage.getItem('scrollToMenu') === 'true') {
  sessionStorage.removeItem('scrollToMenu');

  setTimeout(() => {
    const targetElement = document.querySelector(targetId);
    if (targetElement) {
      console.log('Scrolling to menu on page load');
      targetElement.scrollIntoView({ behavior: 'smooth' });

      // Remove hash from URL without reloading the page
      history.replaceState(null, '', window.location.pathname + window.location.search);
    } else {
      console.log('Menu element not found on page load');
    }
  }, 300);
}

});

//After message is submited via RS form  the message to dissappear and form reload
jQuery(document).on('gform_confirmation_loaded', function(event, formId) {
  var $confirmationWrapper = jQuery('#gform_confirmation_wrapper_' + formId);

  setTimeout(function() {
    // AJAX request to get fresh form HTML
    jQuery.ajax({
      url: '/wp-admin/admin-ajax.php',
      method: 'POST',
      data: {
        action: 'reload_gf_form',
        form_id: formId
      },
      success: function(response) {
        if(response.success && response.data.form_html) {
          // Replace confirmation wrapper content with fresh form
          $confirmationWrapper.html(response.data.form_html);
        }
      },
      error: function() {
        console.error('Failed to reload Gravity Form');
      }
    });
  }, 5000);
});


//Validation for MKD phone number field Form id 1
document.addEventListener('DOMContentLoaded', function () {
  // Run only if form with ID 1 exists
  if (!document.getElementById('gform_wrapper_1')) return;

  const input = document.getElementById('input_1_4');
  const errorDiv = document.getElementById('input_1_4_error');
  const PREFIX = '07';

  // When focused, if empty, prefill with '07'
  input.addEventListener('focus', function () {
    if (!input.value.startsWith(PREFIX)) {
      input.value = PREFIX;
    }
    setTimeout(() => input.setSelectionRange(input.value.length, input.value.length), 0);
  });

  // Prevent moving cursor before prefix
  function fixCursor() {
    if (input.selectionStart < PREFIX.length) {
      input.setSelectionRange(PREFIX.length, PREFIX.length);
    }
  }
  ['click', 'keyup', 'mouseup', 'focus'].forEach(evt => input.addEventListener(evt, fixCursor));

  input.addEventListener('keydown', function (e) {
    // Prevent backspace/delete before prefix
    if ((e.key === 'Backspace' || e.key === 'Delete') && input.selectionStart <= PREFIX.length) {
      e.preventDefault();
    }
  });

  input.addEventListener('input', function () {
    // Remove all non-digit characters
    let val = input.value.replace(/\D/g, '');

    // Always start with '07'
    if (!val.startsWith(PREFIX)) {
      val = PREFIX;
    }

    // Limit length to 9 digits total (07 + 7 digits)
    if (val.length > 9) {
      val = val.slice(0, 9);
    }

    input.value = val;

    // Validate length after prefix
    let digitsAfterPrefix = val.slice(PREFIX.length);
    if (digitsAfterPrefix.length === 7) {
      errorDiv.style.display = 'none';
      input.setAttribute('aria-invalid', 'false');
    } else {
      errorDiv.textContent = 'Please enter exactly 9 digits starting with "07".';
      errorDiv.style.display = 'block';
      input.setAttribute('aria-invalid', 'true');
    }
    fixCursor();
  });

  input.addEventListener('blur', function () {
    // Hide error if input empty or complete
    let val = input.value;
    let digitsAfterPrefix = val.slice(PREFIX.length);
    if (digitsAfterPrefix.length === 7 || digitsAfterPrefix.length === 0) {
      errorDiv.style.display = 'none';
      input.setAttribute('aria-invalid', 'false');
    }
  });
});

window.addEventListener("load", function () {
  const overlay = document.querySelector(".box1-wrapper::before"); // this won't work because pseudo-elements can't be directly selected

  // Instead, apply blur to a real DOM element layered like a pseudo-element
  const boxWrapper = document.querySelector(".box1-wrapper");
  if (boxWrapper) {
    const blurDiv = document.createElement("div");
    blurDiv.className = "hero-blur-overlay";
    boxWrapper.prepend(blurDiv);
  }
});

function defer_scripts($tag, $handle, $src) {
    // Defer everything except jQuery migrate or core if necessary
    if (!is_admin() && !in_array($handle, ['jquery-core', 'jquery-migrate'])) {
        return '<script src="' . $src . '" defer></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'defer_scripts', 10, 3);
