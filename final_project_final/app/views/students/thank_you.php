<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Student Course Hub</title>
    <style>
    /* Header Styles */
.site-header {
    background-color: #005EB8;
    color: white;
    padding: 1rem 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 100;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo img {
    height: 50px;
    width: auto;
}

.main-nav ul {
    display: flex;
    list-style: none;
}

.main-nav ul li {
    margin-left: 2rem;
}

.main-nav ul li a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    transition: color 0.3s ease;
}

.main-nav ul li a:hover,
.main-nav ul li a:focus {
    color: #FFCD00;
}
    
 
    .thank-you-section {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: 3rem 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.success-illustration {
    margin-bottom: 2rem;
}

.success-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    background-color: #28a745;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.success-icon svg {
    color: white;
    width: 40px;
    height: 40px;
}

.thank-you-content h1 {
    color: #005EB8;
    margin-bottom: 1rem;
    font-size: 2.5rem;
}

.thank-you-content .lead {
    font-size: 1.3rem;
    color: #0072CE;
    margin-bottom: 1rem;
}

.thank-you-content p {
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
}

.next-steps {
    text-align: left;
    margin: 2rem 0;
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
}

.next-steps h2 {
    color: #005EB8;
    margin-bottom: 1rem;
}

.next-steps ul {
    margin-left: 1.5rem;
}

.next-steps li {
    margin-bottom: 0.5rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
}

.related-info {
    margin-top: 3rem;
}

.related-info h2 {
    color: #005EB8;
    margin-bottom: 1.5rem;
    text-align: center;
}

.info-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.info-card {
    background-color: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    text-align: center;
}

.info-card h3 {
    color: #005EB8;
    margin-bottom: 0.5rem;
}

.info-card p {
    margin-bottom: 1rem;
    color: #666;
}

.info-card a {
    color: #005EB8;
    font-weight: 500;
    text-decoration: none;
}

.info-card a:hover,
.info-card a:focus {
    text-decoration: underline;
}
/* Footer Styles */
.site-footer {
    background-color: #333;
    color: white;
    padding: 3rem 0 1rem;
    margin-top: 3rem;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.footer-section h3 {
    margin-bottom: 1rem;
    color: #FFCD00;
}

.footer-section ul {
    list-style: none;
}

.footer-section ul li {
    margin-bottom: 0.5rem;
}

.footer-section a {
    color: white;
    text-decoration: none;
}

.footer-section a:hover,
.footer-section a:focus {
    color: #FFCD00;
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-links a {
    padding: 0.5rem;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transition: background-color 0.3s ease;
}

.social-links a:hover,
.social-links a:focus {
    background-color: rgba(255, 255, 255, 0.2);
}
</style>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    </div>
                <nav class="main-nav">
                    <ul>
                        <li><a href="programme-list.html">Programmes</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <section class="thank-you-section">
                <div class="success-illustration">
                    <div class="success-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                </div>

                <div class="thank-you-content">
                    <h1>Thank You for Your Interest!</h1>
                    <p class="lead">Your registration has been successfully submitted.</p>
                    <p>We've received your information and will contact you soon with more details about the programme. You'll also receive a confirmation email shortly.</p>

                    <div class="next-steps">
                        <h2>What Happens Next?</h2>
                        <ul>
                            <li>You'll receive a confirmation email with your registration details</li>
                            <li>Our admissions team will review your information</li>
                            <li>You'll receive personalized programme information within 3-5 business days</li>
                            <li>You'll be invited to upcoming open days and information sessions</li>
                        </ul>
                    </div>

                    <div class="action-buttons">
                        <a href="programme-list.html" class="btn btn-primary">Browse More Programmes</a>
                        <a href="#" class="btn btn-secondary">Download Brochure</a>
                    </div>
                </div>
            </section>

            <section class="related-info">
                <h2>Useful Information</h2>
                <div class="info-cards">
                    <div class="info-card">
                        <h3>Admissions Process</h3>
                        <p>Learn about our comprehensive admissions process and requirements.</p>
                        <a href="#">Learn More</a>
                    </div>
                    <div class="info-card">
                        <h3>Student Life</h3>
                        <p>Discover what it's like to be a student at our institution.</p>
                        <a href="#">Explore Campus</a>
                    </div>
                    <div class="info-card">
                        <h3>Funding Options</h3>
                        <p>Information about tuition fees, scholarships, and financial support.</p>
                        <a href="#">View Options</a>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>Email: <a href="mailto:admissions@example.edu">admissions@example.edu</a></p>
                    <p>Phone: +44 (0) 123 456 7890</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Accessibility</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Follow Us</h3>
                    <ul class="social-links">
                        <li><a href="#" aria-label="Facebook">Facebook</a></li>
                        <li><a href="#" aria-label="Twitter">Twitter</a></li>
                        <li><a href="#" aria-label="LinkedIn">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Student Course Hub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>