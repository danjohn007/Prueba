package com.elearning.platform.repository;

import com.elearning.platform.model.Evaluation;
import com.elearning.platform.model.User;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface EvaluationRepository extends JpaRepository<Evaluation, Long> {
    
    List<Evaluation> findByIsActiveTrue();
    
    List<Evaluation> findByCreatedBy(User createdBy);
    
    List<Evaluation> findByIsActiveTrueOrderByCreatedAtDesc();
}