package userclient.util;

import javafx.fxml.FXML;
import javafx.scene.control.Label;
import javafx.scene.layout.VBox;

/**
 * @author Thijs
 *
 */
public abstract class LabelControl extends VBox {

	protected final String text;
	
	@FXML
	protected Label lbLabelField;
	
	public LabelControl(String text) {
		this.text = text.toUpperCase();
	}
	
	public void initialize() {
		this.lbLabelField.setText(this.text);
	}

	/**
	 * @return the lbLabelField
	 */
	public Label getLbLabelField() {
		return lbLabelField;
	}	
}
