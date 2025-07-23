package com.elearning.platform.controller;

import com.elearning.platform.model.Evaluation;
import com.elearning.platform.model.User;
import com.elearning.platform.service.EvaluationService;
import com.elearning.platform.service.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.Authentication;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;

import java.util.List;

@Controller
@RequestMapping("/student")
public class StudentController {

    @Autowired
    private EvaluationService evaluationService;

    @Autowired
    private UserService userService;

    @GetMapping("/dashboard")
    public String studentDashboard(Model model, Authentication authentication) {
        User student = userService.findByEmail(authentication.getName()).orElse(null);
        List<Evaluation> availableEvaluations = evaluationService.findActiveEvaluations();
        
        model.addAttribute("student", student);
        model.addAttribute("evaluations", availableEvaluations);
        
        return "student/dashboard";
    }

    @GetMapping("/profile")
    public String profile(Model model, Authentication authentication) {
        User student = userService.findByEmail(authentication.getName()).orElse(null);
        
        model.addAttribute("student", student);
        
        return "student/profile";
    }

    @GetMapping("/evaluations")
    public String listEvaluations(Model model) {
        List<Evaluation> evaluations = evaluationService.findActiveEvaluations();
        model.addAttribute("evaluations", evaluations);
        
        return "student/evaluations";
    }
}