package userclient.util;

import javafx.beans.NamedArg;
import javafx.fxml.FXML;
import javafx.scene.control.ComboBox;

/**
 * @author Thijs
 *
 */
public class LabelBox<T> extends LabelControl{
	
	@FXML
	private ComboBox<T> cbLabelField;
	
	public LabelBox(@NamedArg("text") String text) {
		super(text);
		new Loader("LabelBox", this);
	}
	
	public void initialize() {
		super.initialize();
	}
	
	/**
	 * @return the tfLabelField
	 */
	public ComboBox<T> getCbLabelField() {
		return cbLabelField;
	}
	
	
}
