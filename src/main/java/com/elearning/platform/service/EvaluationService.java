package com.elearning.platform.service;

import com.elearning.platform.model.Evaluation;
import com.elearning.platform.model.User;
import com.elearning.platform.repository.EvaluationRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class EvaluationService {

    @Autowired
    private EvaluationRepository evaluationRepository;

    public List<Evaluation> findAll() {
        return evaluationRepository.findAll();
    }

    public List<Evaluation> findActiveEvaluations() {
        return evaluationRepository.findByIsActiveTrueOrderByCreatedAtDesc();
    }

    public List<Evaluation> findByCreatedBy(User admin) {
        return evaluationRepository.findByCreatedBy(admin);
    }

    public Optional<Evaluation> findById(Long id) {
        return evaluationRepository.findById(id);
    }

    public Evaluation save(Evaluation evaluation) {
        return evaluationRepository.save(evaluation);
    }

    public void delete(Long id) {
        evaluationRepository.deleteById(id);
    }

    public void deactivate(Long id) {
        Optional<Evaluation> evaluationOpt = evaluationRepository.findById(id);
        if (evaluationOpt.isPresent()) {
            Evaluation evaluation = evaluationOpt.get();
            evaluation.setIsActive(false);
            evaluationRepository.save(evaluation);
        }
    }

    public void activate(Long id) {
        Optional<Evaluation> evaluationOpt = evaluationRepository.findById(id);
        if (evaluationOpt.isPresent()) {
            Evaluation evaluation = evaluationOpt.get();
            evaluation.setIsActive(true);
            evaluationRepository.save(evaluation);
        }
    }
}