# Web Systems Lab 1: Portfolio Website

## Project Overview
This lab focuses on creating professional portfolio websites using pure HTML, CSS, and optional JavaScript. The project consists of both group and individual components, demonstrating web development fundamentals and semantic markup skills.

## Team Information
**Team Name:** Data Pulse 
**Team Slogan:** Building Digital Solutions That Last 
**Team Members:**
- [Member 1 Name] - [RCS ID] - [Email]
- [Member 2 Name] - [RCS ID] - [Email]
- [Member 3 Name] - [RCS ID] - [Email]

## Repository Links
- **Group Repository:** [GitHub URL]
- **Individual Repository:** [GitHub URL if separate]
- **Live Site:** [GitHub Pages URL]

## Work Log

### Week 1: Project Planning and Setup
**Date:** [Date]
- Set up GitHub repository with proper file structure
- Discussed team responsibilities and timeline
- Researched portfolio design inspiration from:
  - [Source 1]
  - [Source 2]
  - [Source 3]
- Created initial HTML file structure

### Week 2: Group Portfolio Development
**Date:** [Date]
- Developed team branding (name, slogan, logo concept)
- Created mock-up screenshots from previous projects
- Implemented group portfolio layout in index.html
- Added team member photos and basic information

**Challenges Encountered:**
- **Issue:** Difficulty with CSS flexbox layout for team member grid
- **Solution:** Researched CSS Grid tutorials on [specific source] and implemented grid-template-areas
- **Learning:** Grid is more suitable for complex layouts than flexbox in this context

### Week 3: Individual Portfolio Pages
**Date:** [Date]
- Created personal portfolio page (rcsid.html)
- Added all required sections: contact info, education, experience, skills
- Implemented responsive design for mobile compatibility
- Added professional headshot and formatted contact information

**Challenges Encountered:**
- **Issue:** Contact information layout was not visually appealing
- **Solution:** Used CSS flexbox for contact cards and added subtle shadows
- **Resource Used:** [Tutorial link or inspiration source]

### Week 4: Microformats Implementation
**Date:** [Date]
- Researched hCard microformat specifications
- Implemented semantic markup for contact information
- Added vcard, fn, email, tel, and adr classes appropriately
- Tested microformat validation using online tools

**Challenges Encountered:**
- **Issue:** Initial hCard implementation was not properly structured
- **Solution:** Studied microformats.org documentation and corrected nested class structure
- **Learning:** Importance of semantic web standards for data portability

### Week 5: Styling and Validation
**Date:** [Date]
- Refined CSS styling for professional appearance
- Ensured consistent 2-space indentation throughout
- Added comments to complex CSS sections
- Validated HTML and CSS using W3C validators

**Final Testing:**
- Tested in Chrome and Firefox browsers
- Verified all links work correctly
- Confirmed GitHub Pages deployment is functional
- Double-checked hCard implementation

## Problem-Solving Documentation

### Major Challenges and Solutions

1. **CSS Layout Issues**
   - **Problem:** Team member cards were not aligning properly on different screen sizes
   - **Research:** Studied CSS Grid tutorials on MDN Web Docs
   - **Solution:** Implemented CSS Grid with responsive breakpoints
   - **Source:** https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Grid_Layout

2. **Microformats Understanding**
   - **Problem:** Initial confusion about proper hCard implementation
   - **Research:** Read microformats.org documentation and examples
   - **Solution:** Created proper nested structure with correct class names
   - **Source:** http://microformats.org/wiki/hcard

3. **Image Optimization**
   - **Problem:** Large image files were slowing page load
   - **Research:** Looked up best practices for web image optimization
   - **Solution:** Resized images to appropriate dimensions and compressed
   - **Tool Used:** [Image compression tool/method]

### Learning Moments
- Discovered the importance of semantic HTML for accessibility
- Learned that CSS Grid is more powerful than initially thought
- Understood how microformats contribute to the semantic web
- Gained appreciation for proper code documentation and commenting

## Technical Implementation

### File Structure
```
lab1/
├── index.html          # Group portfolio homepage
├── style.css           # Shared stylesheet
├── [rcsid1].html       # Individual portfolio 1
├── [rcsid2].html       # Individual portfolio 2
├── [rcsid3].html       # Individual portfolio 3
├── images/             # Photos, logos, screenshots
│   ├── team-logo.png
│   ├── member-photos/
│
└── README.md           # This documentation
```

### Technologies Used
- **HTML5:** Semantic markup with proper document structure
- **CSS3:** Grid, Flexbox, responsive design, custom properties
- **JavaScript:** [If used, describe implementation]
- **Microformats:** hCard for contact information

### Design Decisions
- Chose a minimalist, professional aesthetic
- Used consistent color scheme: [describe colors]
- Selected readable typography: [font choices]
- Implemented mobile-first responsive design
- Added subtle animations for improved user experience

## Validation Results
- **HTML Validation:**  All pages pass W3C HTML validator
- **CSS Validation:**  Stylesheet passes W3C CSS validator
- **Browser Testing:**  Confirmed compatibility in Chrome and Firefox
- **Microformats:**  hCard implementation verified

## Citations and Sources

### Design Inspiration
- [Portfolio example 1 URL] - Layout inspiration for team page
- [Portfolio example 2 URL] - Individual page structure reference
- [Design system URL] - Color palette and typography choices

### Technical Resources
- MDN Web Docs (https://developer.mozilla.org) - CSS Grid and Flexbox tutorials
- W3Schools (https://www.w3schools.com) - HTML5 semantic elements reference
- Microformats.org (http://microformats.org/wiki/hcard) - hCard specification
- CSS-Tricks (https://css-tricks.com) - Various CSS implementation guides

### Tools and Validators
- W3C HTML Validator (https://validator.w3.org/)
- W3C CSS Validator (https://jigsaw.w3.org/css-validator/)
- GitHub Pages for hosting
- [Image editing tool used]


## Individual Contributions
- **[Jason]:** Group page layout, team branding, CSS framework
- **[Temitayo ]:** Individual portfolios, microformats research, validation
- ** [Eric]:**  Image preparation, responsive design, documentation

## Reflection
This project provided valuable experience in fundamental web development skills. Key takeaways include the importance of semantic HTML, the power of modern CSS layout techniques, and the value of proper documentation. The microformats requirement introduced us to semantic web concepts that enhance data portability and accessibility.

## Future Improvements
- Add more interactive JavaScript features
- Implement dark mode toggle
- Add project filtering functionality
- Enhance mobile navigation experience
- Include accessibility features (ARIA labels, keyboard navigation)

---

**Course:** Web Systems  
**Instructor:** Prof. Garcia  
**Due Date:** September 19, 2025  
**Submission:** LMS by 11:59 PM ET