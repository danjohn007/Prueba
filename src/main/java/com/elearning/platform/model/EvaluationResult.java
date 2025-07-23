package com.elearning.platform.model;

import jakarta.persistence.*;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;

@Entity
@Table(name = "evaluation_results")
public class EvaluationResult {
    
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "student_id", nullable = false)
    private User student;
    
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "evaluation_id", nullable = false)
    private Evaluation evaluation;
    
    @Column(name = "score")
    private Double score;
    
    @Column(name = "max_score")
    private Double maxScore;
    
    @Column(name = "percentage")
    private Double percentage;
    
    @Column(name = "passed")
    private Boolean passed;
    
    @Column(name = "started_at")
    private LocalDateTime startedAt;
    
    @Column(name = "completed_at")
    private LocalDateTime completedAt;
    
    @Column(name = "time_taken_minutes")
    private Integer timeTakenMinutes;
    
    @OneToMany(mappedBy = "evaluationResult", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    private List<StudentAnswer> studentAnswers = new ArrayList<>();
    
    // Constructors
    public EvaluationResult() {
        this.startedAt = LocalDateTime.now();
    }
    
    public EvaluationResult(User student, Evaluation evaluation) {
        this();
        this.student = student;
        this.evaluation = evaluation;
    }
    
    // Getters and Setters
    public Long getId() {
        return id;
    }
    
    public void setId(Long id) {
        this.id = id;
    }
    
    public User getStudent() {
        return student;
    }
    
    public void setStudent(User student) {
        this.student = student;
    }
    
    public Evaluation getEvaluation() {
        return evaluation;
    }
    
    public void setEvaluation(Evaluation evaluation) {
        this.evaluation = evaluation;
    }
    
    public Double getScore() {
        return score;
    }
    
    public void setScore(Double score) {
        this.score = score;
    }
    
    public Double getMaxScore() {
        return maxScore;
    }
    
    public void setMaxScore(Double maxScore) {
        this.maxScore = maxScore;
    }
    
    public Double getPercentage() {
        return percentage;
    }
    
    public void setPercentage(Double percentage) {
        this.percentage = percentage;
    }
    
    public Boolean getPassed() {
        return passed;
    }
    
    public void setPassed(Boolean passed) {
        this.passed = passed;
    }
    
    public LocalDateTime getStartedAt() {
        return startedAt;
    }
    
    public void setStartedAt(LocalDateTime startedAt) {
        this.startedAt = startedAt;
    }
    
    public LocalDateTime getCompletedAt() {
        return completedAt;
    }
    
    public void setCompletedAt(LocalDateTime completedAt) {
        this.completedAt = completedAt;
    }
    
    public Integer getTimeTakenMinutes() {
        return timeTakenMinutes;
    }
    
    public void setTimeTakenMinutes(Integer timeTakenMinutes) {
        this.timeTakenMinutes = timeTakenMinutes;
    }
    
    public List<StudentAnswer> getStudentAnswers() {
        return studentAnswers;
    }
    
    public void setStudentAnswers(List<StudentAnswer> studentAnswers) {
        this.studentAnswers = studentAnswers;
    }
    
    public void calculateScore() {
        if (studentAnswers == null || studentAnswers.isEmpty()) {
            this.score = 0.0;
            this.percentage = 0.0;
            return;
        }
        
        double totalScore = 0.0;
        double totalMaxScore = 0.0;
        
        for (StudentAnswer studentAnswer : studentAnswers) {
            if (studentAnswer.getIsCorrect() != null && studentAnswer.getIsCorrect()) {
                totalScore += studentAnswer.getQuestion().getPoints();
            }
            totalMaxScore += studentAnswer.getQuestion().getPoints();
        }
        
        this.score = totalScore;
        this.maxScore = totalMaxScore;
        this.percentage = totalMaxScore > 0 ? (totalScore / totalMaxScore) * 100 : 0.0;
        this.passed = this.percentage >= evaluation.getPassingScore();
    }
}