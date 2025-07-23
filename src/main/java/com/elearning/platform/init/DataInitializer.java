package com.elearning.platform.init;

import com.elearning.platform.model.User;
import com.elearning.platform.service.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.CommandLineRunner;
import org.springframework.context.annotation.Profile;
import org.springframework.stereotype.Component;

@Component
@Profile("!test")
public class DataInitializer implements CommandLineRunner {

    @Autowired
    private UserService userService;

    @Override
    public void run(String... args) throws Exception {
        // Create default admin user if it doesn't exist
        if (!userService.existsByEmail("admin@elearning.com")) {
            User admin = new User();
            admin.setFirstName("Admin");
            admin.setLastName("Sistema");
            admin.setEmail("admin@elearning.com");
            admin.setPassword("admin123");
            admin.setRole(User.Role.ADMIN);
            
            userService.save(admin);
            System.out.println("Default admin user created:");
            System.out.println("Email: admin@elearning.com");
            System.out.println("Password: admin123");
        }
        
        // Create a test student user if it doesn't exist
        if (!userService.existsByEmail("estudiante@test.com")) {
            User student = new User();
            student.setFirstName("Juan");
            student.setLastName("Pérez");
            student.setEmail("estudiante@test.com");
            student.setPassword("student123");
            student.setRole(User.Role.STUDENT);
            
            userService.save(student);
            System.out.println("Test student user created:");
            System.out.println("Email: estudiante@test.com");
            System.out.println("Password: student123");
        }
    }
}