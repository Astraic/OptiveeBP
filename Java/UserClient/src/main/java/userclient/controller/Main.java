package userclient.controller;

import javafx.application.Application;
import javafx.scene.Scene;
import javafx.stage.Stage;
import userclient.util.Loader;

public class Main extends Application {

	@Override
	public void start(Stage primaryStage) throws Exception {
		Loader root = new Loader("RootPane");
		Scene primaryScene = new Scene(root.getView());
		primaryStage.setFullScreen(true);
		primaryStage.setScene(primaryScene);
		primaryScene.getStylesheets().add(getClass().getResource("/stylesheet.css").toExternalForm());
		primaryStage.show();
	}

	public static void main(String[] args) {
		launch(args);
	}

}
