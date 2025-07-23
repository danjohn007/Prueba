package com.elearning.platform.controller;

import com.elearning.platform.model.Evaluation;
import com.elearning.platform.model.User;
import com.elearning.platform.service.EvaluationService;
import com.elearning.platform.service.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.Authentication;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import jakarta.validation.Valid;
import java.util.List;

@Controller
@RequestMapping("/admin")
public class AdminController {

    @Autowired
    private EvaluationService evaluationService;

    @Autowired
    private UserService userService;

    @GetMapping("/dashboard")
    public String adminDashboard(Model model, Authentication authentication) {
        User admin = userService.findByEmail(authentication.getName()).orElse(null);
        List<Evaluation> evaluations = evaluationService.findByCreatedBy(admin);
        List<User> students = userService.findAllStudents();
        
        model.addAttribute("evaluations", evaluations);
        model.addAttribute("students", students);
        model.addAttribute("admin", admin);
        
        return "admin/dashboard";
    }

    @GetMapping("/evaluations")
    public String listEvaluations(Model model, Authentication authentication) {
        User admin = userService.findByEmail(authentication.getName()).orElse(null);
        List<Evaluation> evaluations = evaluationService.findByCreatedBy(admin);
        
        model.addAttribute("evaluations", evaluations);
        
        return "admin/evaluations";
    }

    @GetMapping("/evaluations/new")
    public String showCreateEvaluationForm(Model model) {
        model.addAttribute("evaluation", new Evaluation());
        return "admin/evaluation-form";
    }

    @PostMapping("/evaluations")
    public String createEvaluation(@Valid @ModelAttribute("evaluation") Evaluation evaluation,
                                   BindingResult result,
                                   Authentication authentication,
                                   RedirectAttributes redirectAttributes) {
        
        if (result.hasErrors()) {
            return "admin/evaluation-form";
        }

        User admin = userService.findByEmail(authentication.getName()).orElse(null);
        evaluation.setCreatedBy(admin);
        evaluationService.save(evaluation);
        
        redirectAttributes.addFlashAttribute("success", "Evaluación creada exitosamente");
        return "redirect:/admin/evaluations";
    }

    @GetMapping("/evaluations/{id}/edit")
    public String showEditEvaluationForm(@PathVariable Long id, Model model) {
        Evaluation evaluation = evaluationService.findById(id).orElse(null);
        if (evaluation == null) {
            return "redirect:/admin/evaluations";
        }
        
        model.addAttribute("evaluation", evaluation);
        return "admin/evaluation-form";
    }

    @PostMapping("/evaluations/{id}")
    public String updateEvaluation(@PathVariable Long id,
                                   @Valid @ModelAttribute("evaluation") Evaluation evaluation,
                                   BindingResult result,
                                   RedirectAttributes redirectAttributes) {
        
        if (result.hasErrors()) {
            return "admin/evaluation-form";
        }

        evaluation.setId(id);
        evaluationService.save(evaluation);
        
        redirectAttributes.addFlashAttribute("success", "Evaluación actualizada exitosamente");
        return "redirect:/admin/evaluations";
    }

    @PostMapping("/evaluations/{id}/deactivate")
    public String deactivateEvaluation(@PathVariable Long id, RedirectAttributes redirectAttributes) {
        evaluationService.deactivate(id);
        redirectAttributes.addFlashAttribute("success", "Evaluación desactivada");
        return "redirect:/admin/evaluations";
    }

    @PostMapping("/evaluations/{id}/activate")
    public String activateEvaluation(@PathVariable Long id, RedirectAttributes redirectAttributes) {
        evaluationService.activate(id);
        redirectAttributes.addFlashAttribute("success", "Evaluación activada");
        return "redirect:/admin/evaluations";
    }

    @PostMapping("/evaluations/{id}/delete")
    public String deleteEvaluation(@PathVariable Long id, RedirectAttributes redirectAttributes) {
        evaluationService.delete(id);
        redirectAttributes.addFlashAttribute("success", "Evaluación eliminada");
        return "redirect:/admin/evaluations";
    }
}