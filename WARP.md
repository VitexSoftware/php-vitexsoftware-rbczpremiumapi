# WARP.md - Working AI Reference for php-vitexsoftware-rbczpremiumapi

## Project Overview
**Type**: Node.js Project/Debian Package
**Purpose**: ![Library Logo](library-logo.svg?raw=true)
**Status**: Active
**Repository**: git@github.com:VitexSoftware/php-vitexsoftware-rbczpremiumapi.git

## Key Technologies
- PHP
- Composer
- Node.js
- npm/yarn
- Debian Packaging

## Architecture & Structure
```
php-vitexsoftware-rbczpremiumapi/
├── src/           # Source code
├── tests/         # Test files
├── docs/          # Documentation
└── ...
```

## Development Workflow

### Prerequisites
- Development environment setup
- Required dependencies

### Setup Instructions
```bash
# Clone the repository
git clone git@github.com:VitexSoftware/php-vitexsoftware-rbczpremiumapi.git
cd php-vitexsoftware-rbczpremiumapi

# Install dependencies
composer install\nnpm install
```

### Build & Run
```bash
npm run build\ndpkg-buildpackage -b -uc
```

### Testing
```bash
composer test\nnpm test
```

## Key Concepts
- **Main Components**: Core functionality and modules
- **Configuration**: Configuration files and environment variables
- **Integration Points**: External services and dependencies
- **Rate Limiting**: API rate limits are enforced per certificate (mTLS client certificate), not per X-IBM-Client-Id. The library automatically calculates the SHA1 fingerprint of the certificate and uses it as the client identifier for rate limit tracking.

## Common Tasks

### Development
- Review code structure
- Implement new features
- Fix bugs and issues

### Deployment
- Build and package
- Deploy to target environment
- Monitor and maintain

## Troubleshooting
- **Common Issues**: Check logs and error messages
- **Debug Commands**: Use appropriate debugging tools
- **Support**: Check documentation and issue tracker

## Additional Notes
- Project-specific conventions
- Development guidelines
- Related documentation
