# Test assignment

## How to start and update project

All `make` commands **require** docker and docker-compose

### First run
Before the first launch of the application, you need to execute command:
```bash
make install
```

### For run project
```bash
make run
```

Frontend url: `http://localhost:8080`

Test user email: `test@example.com`, password: `password`

### For update dependencies & rebuild frontend & migrations
```bash
make update
```

### For run tests
```bash
make test
```

## Notes

The frontend part has been simplified, the code is very simple, because the test of knowledge backend.

The backend implementation is overly complex

For convenience, I created two commits, the first contains the laravel skeleton app(init laravel), the second code implementation
