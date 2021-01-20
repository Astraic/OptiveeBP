package userclient.util;

import java.io.IOException;

import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.layout.GridPane;

public class Loader {
	
	private final FXMLLoader fxmlLoader;
	private final Parent view;
	
	public Loader(String resource) {
		System.out.println(resource);
		fxmlLoader = new FXMLLoader(getClass().getClassLoader().getResource(resource + ".fxml"));
		Parent view = null;
		try {
			System.out.println(fxmlLoader.getLocation());
			view = fxmlLoader.load();
			
		} catch (IOException e) {
			view = new GridPane();
			e.printStackTrace();
		}
		this.view = view;
	}
	
	public Loader(String resource, Node controller) {
		fxmlLoader = new FXMLLoader(getClass().getClassLoader().getResource(resource + ".fxml"));
		fxmlLoader.setRoot(controller);
		fxmlLoader.setController(controller);

		Parent view = null;
		try {
			view = fxmlLoader.load();
		} catch (IOException e) {
			view = new GridPane();
			e.printStackTrace();
		}
		this.view = view;
	}

	public FXMLLoader getFxmlLoader() {
		return fxmlLoader;
	}
	
	public Parent getView() {
		return view;
	}	
}
