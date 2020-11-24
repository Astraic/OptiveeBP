package OptiVee.Model;

import java.time.LocalDate;
import java.time.LocalTime;

public class Classification {

    private Animal animalId;
    private LocalDate date;
    private LocalTime time;
    private Category category;
    private FatGrade fatGrade;
    private MeatGrade meatGrade;
    private double amount;

    public Classification(Animal animalId, LocalDate date, LocalTime time, Category category, FatGrade fatGrade, MeatGrade meatGrade, double amount) {
        this.animalId = animalId;
        this.date = date;
        this.time = time;
        this.category = category;
        this.fatGrade = fatGrade;
        this.meatGrade = meatGrade;
        this.amount = amount;
    }

    public Animal getAnimalId() {
        return animalId;
    }

    public void setAnimalId(Animal animalId) {
        this.animalId = animalId;
    }

    public LocalDate getDate() {
        return date;
    }

    public void setDate(LocalDate date) {
        this.date = date;
    }

    public LocalTime getTime() {
        return time;
    }

    public void setTime(LocalTime time) {
        this.time = time;
    }

    public Category getCategory() {
        return category;
    }

    public void setCategory(Category category) {
        this.category = category;
    }

    public FatGrade getFatGrade() {
        return fatGrade;
    }

    public void setFatGrade(FatGrade fatGrade) {
        this.fatGrade = fatGrade;
    }

    public MeatGrade getMeatGrade() {
        return meatGrade;
    }

    public void setMeatGrade(MeatGrade meatGrade) {
        this.meatGrade = meatGrade;
    }

    public double getAmount() {
        return amount;
    }

    public void setAmount(double amount) {
        this.amount = amount;
    }
}