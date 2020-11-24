package OptiVee.Model;

import java.util.UUID;

public class FeedingMachine {

    private UUID id;
    private int group;
    private Feed feedName;
    private double allocated, portionSize;

    public FeedingMachine(UUID id, int group, Feed feedName, double allocated, double portionSize) {
        this.id = id;
        this.group = group;
        this.feedName = feedName;
        this.allocated = allocated;
        this.portionSize = portionSize;
    }

    public UUID getId() {
        return id;
    }

    public void setId(UUID id) {
        this.id = id;
    }

    public int getGroup() {
        return group;
    }

    public void setGroup(int group) {
        this.group = group;
    }

    public Feed getFeedName() {
        return feedName;
    }

    public void setFeedName(Feed feedName) {
        this.feedName = feedName;
    }

    public double getAllocated() {
        return allocated;
    }

    public void setAllocated(double allocated) {
        this.allocated = allocated;
    }

    public double getPortionSize() {
        return portionSize;
    }

    public void setPortionSize(double portionSize) {
        this.portionSize = portionSize;
    }
}