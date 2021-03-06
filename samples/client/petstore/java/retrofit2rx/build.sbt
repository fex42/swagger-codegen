lazy val root = (project in file(".")).
  settings(
    organization := "io.swagger",
    name := "swagger-petstore-retrofit2-rx",
    version := "1.0.0",
    scalaVersion := "2.11.4",
    scalacOptions ++= Seq("-feature"),
    javacOptions in compile ++= Seq("-Xlint:deprecation"),
    publishArtifact in (Compile, packageDoc) := false,
    resolvers += Resolver.mavenLocal,
    libraryDependencies ++= Seq(
      "com.squareup.retrofit2" % "retrofit" % "2.0.2" % "compile",
      "com.squareup.retrofit2" % "converter-scalars" % "2.0.2" % "compile",
      "com.squareup.retrofit2" % "converter-gson" % "2.0.2" % "compile",
      "com.squareup.retrofit2" % "adapter-rxjava" % "2.0.2" % "compile",
      "io.reactivex" % "rxjava" % "1.1.3" % "compile",
      "io.swagger" % "swagger-annotations" % "1.5.8" % "compile",
      "org.apache.oltu.oauth2" % "org.apache.oltu.oauth2.client" % "1.0.1" % "compile",
      "joda-time" % "joda-time" % "2.9.3" % "compile",
      "junit" % "junit" % "4.12" % "test",
      "com.novocode" % "junit-interface" % "0.10" % "test"
    )
  )
