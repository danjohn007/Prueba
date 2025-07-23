package com.elearning.platform.repository;

import com.elearning.platform.model.Question;
import com.elearning.platform.model.Evaluation;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface QuestionRepository extends JpaRepository<Question, Long> {
    
    List<Question> findByEvaluation(Evaluation evaluation);
    
    List<Question> findByEvaluationOrderById(Evaluation evaluation);
}