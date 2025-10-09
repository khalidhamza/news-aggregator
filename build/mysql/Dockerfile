FROM mysql:8.0

# Copy custom MySQL configuration
COPY my.cnf /etc/mysql/conf.d/custom.cnf

# Copy initialization script
COPY init.sql /docker-entrypoint-initdb.d/

# Set proper permissions
RUN chmod 644 /etc/mysql/conf.d/custom.cnf

# Expose MySQL port
EXPOSE 3306

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=30s --retries=3 \
  CMD mysqladmin ping -h localhost -u root -p$MYSQL_ROOT_PASSWORD || exit 1