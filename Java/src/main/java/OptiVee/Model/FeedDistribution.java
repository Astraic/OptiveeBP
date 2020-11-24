package OptiVee.Model;

import java.time.LocalDate;
import java.time.LocalTime;

public class FeedDistribution {

    private Animal animalId;
    private LocalDate date;
    private LocalTime time;
    private Feed feedName;
    private double portionSize, allocated, consumed;

    public FeedDistribution(Animal animalId, LocalDate date, LocalTime time, Feed feedName, double portionSize, double allocated, double consumed) {
        this.animalId = animalId;
        this.date = date;
        this.time = time;
        this.feedName = feedName;
        this.portionSize = portionSize;
        this.allocated = allocated;
        this.consumed = consumed;
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

    public Feed getFeedName() {
        return feedName;
    }

    public void setFeedName(Feed feedName) {
        this.feedName = feedName;
    }

    public double getPortionSize() {
        return portionSize;
    }

    public void setPortionSize(double portionSize) {
        this.portionSize = portionSize;
    }

    public double getAllocated() {
        return allocated;
    }

    public void setAllocated(double allocated) {
        this.allocated = allocated;
    }

    public double getConsumed() {
        return consumed;
    }

    public void setConsumed(double consumed) {
        this.consumed = consumed;
    }
}