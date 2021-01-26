package userclient.util;

import javafx.beans.NamedArg;
import javafx.fxml.FXML;
import javafx.scene.control.TextField;

/**
 * @author Thijs
 *
 */
public class LabelField extends LabelControl{
	
	@FXML
	private TextField tfLabelField;
	
	public LabelField(@NamedArg("text") String text) {
		super(text);
		new Loader("LabelField", this);
	}
	
	public void initialize() {
		super.initialize();
	}
	
	/**
	 * @return the tfLabelField
	 */
	public TextField getTfLabelField() {
		return tfLabelField;
	}
	
	
}
