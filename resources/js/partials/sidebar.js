$(document).ready(function() {
  const sidebarState = localStorage.getItem('sidebarState');
  if (sidebarState === 'collapsed') {
    $('#sidebar').addClass('collapsed');
    $('#sidebar').removeClass('expanded');
  } else {
    $('#sidebar').removeClass('collapsed');
    $('#sidebar').addClass('expanded');
  }

  // Sidebar toggle functionality
  $('#toggleSidebar').on('click', function () {
    $('#sidebar').toggleClass('collapsed');

    if ($('#sidebar').hasClass('collapsed')) {
      $('#sidebar').removeClass('expanded');
      localStorage.setItem('sidebarState', 'collapsed');
    } else {
      $('#sidebar').addClass('expanded');
      localStorage.setItem('sidebarState', 'expanded');
    }
  });

  $('a').on('click', function() {
    $('#sidebar').css('transition', 'none'); 
    $('#sidebar-content').css('transition', 'none');
  });

  $(window).on('load', function() {
    setTimeout(function() {
      $('#sidebar').css('transition', 'width 0.3s ease');
      $('#sidebar-content').css('transition', 'all 0.4s ease'); 
    }, 500); 

    
  });
});
