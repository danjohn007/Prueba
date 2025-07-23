package com.elearning.platform.repository;

import com.elearning.platform.model.EvaluationResult;
import com.elearning.platform.model.User;
import com.elearning.platform.model.Evaluation;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public interface EvaluationResultRepository extends JpaRepository<EvaluationResult, Long> {
    
    List<EvaluationResult> findByStudent(User student);
    
    List<EvaluationResult> findByEvaluation(Evaluation evaluation);
    
    Optional<EvaluationResult> findByStudentAndEvaluation(User student, Evaluation evaluation);
    
    List<EvaluationResult> findByStudentOrderByCompletedAtDesc(User student);
}