// Constitution Web App JavaScript Functions
// Lab 02

/**
 * Show the selected section and hide others
 * @param {string} sectionId - The ID of the section to show
 */
function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.classList.remove('active');
    });
    
    // Show selected section
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.classList.add('active');
    }
    
    // Update navigation button styles
    const buttons = document.querySelectorAll('.nav-btn');
    buttons.forEach(btn => {
        // Reset to default gradient
        if (btn.tagName === 'BUTTON') {
            btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
        }
    });
    
    // Highlight the active button (only for buttons, not links)
    if (event && event.target.tagName === 'BUTTON') {
        event.target.style.background = 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)';
    }
    
    // Smooth scroll to top for better user experience
    window.scrollTo({ 
        top: 0, 
        behavior: 'smooth' 
    });
}

/**
 * Toggle visibility of text elements (like original Constitution text)
 * @param {string} elementId - The ID of the element to toggle
 */
function toggleText(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        if (element.style.display === 'none' || element.style.display === '') {
            element.style.display = 'block';
            // Add smooth reveal animation
            element.style.opacity = '0';
            element.style.transform = 'translateY(-10px)';
            
            // Animate in
            setTimeout(() => {
                element.style.transition = 'all 0.3s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, 10);
        } else {
            element.style.opacity = '0';
            element.style.transform = 'translateY(-10px)';
            
            // Hide after animation
            setTimeout(() => {
                element.style.display = 'none';
                element.style.transition = '';
            }, 300);
        }
    }
}

/**
 * Initialize the app when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', function() {
    // Ensure the preamble section is shown by default
    showSection('preamble');
    
    // Add smooth scrolling to all navigation buttons
    const navButtons = document.querySelectorAll('.nav-btn');
    navButtons.forEach(btn => {
        if (btn.tagName === 'BUTTON') {
            btn.addEventListener('click', function() {
                // Add a subtle click animation
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 100);
            });
        }
    });
    
    // Add hover effects to articles and amendments
    const articles = document.querySelectorAll('.article, .amendment');
    articles.forEach(article => {
        article.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 15px 35px rgba(74, 85, 104, 0.15)';
        });
        
        article.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '0 8px 30px rgba(74, 85, 104, 0.1)';
        });
    });
    
    // Add click animation to toggle buttons
    const toggleButtons = document.querySelectorAll('.toggle-btn');
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 100);
        });
    });
    
    // Add keyboard navigation support
    document.addEventListener('keydown', function(e) {
        // Use number keys 1-4 to switch between sections
        const keyMap = {
            '49': 'preamble',    // Key '1'
            '50': 'history',     // Key '2'
            '51': 'articles',    // Key '3'
            '52': 'bill-of-rights' // Key '4'
        };
        
        if (keyMap[e.keyCode]) {
            showSection(keyMap[e.keyCode]);
            e.preventDefault();
        }
    });
    
    // Add loading animation (fade in effect)
    const container = document.querySelector('.container');
    if (container) {
        container.style.opacity = '0';
        container.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            container.style.transition = 'all 0.8s ease';
            container.style.opacity = '1';
            container.style.transform = 'translateY(0)';
        }, 100);
    }
});

/**
 * Add accessibility improvements
 */
function initializeAccessibility() {
    // Add ARIA labels to navigation buttons
    const navButtons = document.querySelectorAll('.nav-btn');
    const sections = ['History', 'Articles I-VII', 'Bill of Rights', 'Preamble'];
    
    navButtons.forEach((btn, index) => {
        if (btn.tagName === 'BUTTON' && sections[index]) {
            btn.setAttribute('aria-label', `Navigate to ${sections[index]} section`);
        }
    });
    
    // Add ARIA expanded attributes to toggle buttons
    const toggleButtons = document.querySelectorAll('.toggle-btn');
    toggleButtons.forEach(btn => {
        btn.setAttribute('aria-expanded', 'false');
        
        // Update aria-expanded when clicked
        btn.addEventListener('click', function() {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
        });
    });
    
    // Add skip navigation link
    const skipNav = document.createElement('a');
    skipNav.href = '#main-content';
    skipNav.textContent = 'Skip to main content';
    skipNav.className = 'skip-nav';
    skipNav.style.cssText = `
        position: absolute;
        top: -40px;
        left: 6px;
        background: #667eea;
        color: white;
        padding: 8px;
        text-decoration: none;
        border-radius: 4px;
        z-index: 1000;
    `;
    
    skipNav.addEventListener('focus', function() {
        this.style.top = '6px';
    });
    
    skipNav.addEventListener('blur', function() {
        this.style.top = '-40px';
    });
    
    document.body.insertBefore(skipNav, document.body.firstChild);
}

// Initialize accessibility features when DOM is loaded
document.addEventListener('DOMContentLoaded', initializeAccessibility);

/**
 * Print functionality
 */
function printConstitution() {
    // Show all sections before printing
    const sections = document.querySelectorAll('.section');
    const originalDisplay = [];
    
    sections.forEach((section, index) => {
        originalDisplay[index] = section.style.display;
        section.style.display = 'block';
    });
    
    // Print
    window.print();
    
    // Restore original display states
    sections.forEach((section, index) => {
        section.style.display = originalDisplay[index];
    });
    
    // Reactivate the current section
    const activeSection = document.querySelector('.section.active');
    if (activeSection) {
        showSection(activeSection.id);
    }
}

// Add print button functionality if needed
document.addEventListener('DOMContentLoaded', function() {
    // Add print keyboard shortcut (Ctrl+P or Cmd+P)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.keyCode === 80) {
            e.preventDefault();
            printConstitution();
        }
    });
});