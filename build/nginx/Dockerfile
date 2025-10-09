FROM nginx:alpine

# Copy custom nginx configuration
COPY default.conf /etc/nginx/conf.d/default.conf

# Create directory for application
RUN mkdir -p /var/www/html

# Set working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80

# Start nginx
CMD ["nginx", "-g", "daemon off;"]